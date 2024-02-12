<?php

namespace App\Controller;

use App\Entity\Releves;
use App\Form\RelevesType;
use App\Repository\RelevesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/releves')]
class RelevesController extends AbstractController
{
    #[Route('/', name: 'app_releves_index', methods: ['POST', 'GET'])]
    public function index(RelevesRepository $relevesRepository, Request $request, EntityManagerInterface $em): Response
    {
        $releves = $em->getRepository(Releves::class)->findAll();
    
        $releve = new Releves();
        $form = $this->createForm(RelevesType::class, $releve);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le relevé existe déjà dans la base de données
            $existingReleve = $em->getRepository(Releves::class)->findOneBy([
                // Remplacez 'champ' par le nom du champ que vous voulez vérifier
                'releve_brut' => $releve->getReleveBrut(),
                'date' => $releve->getDate(),
            ]);
    
            // Si le relevé n'existe pas déjà, persistez-le
            if (!$existingReleve) {
                $em->persist($releve);
                $em->flush();
            }
        }
    
        $resultats = [];
        foreach ($releves as $releve) {
            $resultats[] = [
                'releve' => $releve,
                'tableau' => $this->genererTableau($releve),
            ];
        }
    
        return $this->render('releves/index.html.twig', [
            'resultats' => $resultats,
            'form' => $form->createView(),
        ]);
    }
    

    private function genererTableau($releve) {
        $tableauFinal = [];
        $conversion = explode('/', $releve->getReleveBrut());
        for ($j = 0; $j < count($conversion); $j++) {
            $nombreDeUns = $conversion[$j]; // Le nombre de "1" à générer
            $tempArray = []; // Initialise le tableau temporaire
            $tempArray = array_fill(0, $nombreDeUns, 1); // Remplit le tableau avec des "1"
            $tempArray = array_pad($tempArray, 9, 0); // Remplit le reste du tableau avec des "0"
            shuffle($tempArray); // Mélange les valeurs dans le tableau
    
            // Convertit le tableau plat en un tableau 3x3
            $tableauInterne = array_chunk($tempArray, 3);
            $tableauFinal[] = $tableauInterne;
        }
    
        return $tableauFinal;
    }
    
    
  
 /* 
  private function genererTableau($releves) {
    $tableauFinal = [];
    for ($i = 0; $i < 3; $i++) {
        $conversion = explode('/', $releves[$i]->getReleveBrut());

        for ($j = 0; $j < 3; $j++) {
            var_dump("<br> conversion : ", $conversion[$j]);

            $nombreDeUns = $conversion[$j]; // Le nombre de "1" à générer
            var_dump("<br> nombre de 1 : ", $nombreDeUns);
            $tempArray[$j] = []; // Initialise le tableau interne
            $tempArray[$j] = array_fill(0, $nombreDeUns, 1); // Remplit le tableau avec des "1"
            $tempArray[$j] = array_pad($tempArray[$j], 3, 0); // Remplit le reste du tableau avec des "0"
            //shuffle($tempArray); // Mélange les valeurs dans le tableau
            
            $tableauInterne = $tempArray;
        }
        var_dump("<br> tempArray : ", $tempArray);

        $tableauFinal[] = $tableauInterne;           
        //var_dump("<br> finallll : ",$tableauFinal);
    }

    return $tableauFinal;
}*/

    #[Route('/new', name: 'app_releves_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $releve = new Releves();
        $form = $this->createForm(RelevesType::class, $releve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($releve);
            $entityManager->flush();

            return $this->redirectToRoute('app_releves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('releves/_new.html.twig', [
            'releve' => $releve,
            'form' => $form
        ]);
    }
    // fonction qui recupere les données présentes dans un formulaire et les enregistre dans la base de données
    // (ici, la table releves) a l'appui du bouton submit
    // la fonction doit afficher un message de validation si le formulaire est valide
    // la fonction doit actualiser la page index pour afficher les données enregistrées dans la base de données
    // la fonction doit afficher un message d'erreur si le formulaire n'est pas valide


    #[Route('/{id}', name: 'app_releves_show', methods: ['GET'])]
    public function show(Releves $releve): Response
    {
        return $this->render('releves/show.html.twig', [
            'releve' => $releve,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_releves_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Releves $releve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RelevesType::class, $releve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_releves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('releves/edit.html.twig', [
            'releve' => $releve,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_releves_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Releves $releve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$releve->getId(), $request->request->get('_token'))) {
            $entityManager->remove($releve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_releves_index', [], Response::HTTP_SEE_OTHER);
    }

}
