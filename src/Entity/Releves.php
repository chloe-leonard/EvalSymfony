<?php

namespace App\Entity;

use App\Repository\RelevesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelevesRepository::class)]
class Releves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 17)]
    private ?string $releve_brut = null;

    #[ORM\OneToMany(mappedBy: 'releves', targetEntity: Lieu::class)]
    private Collection $id_lieu;

    #[ORM\ManyToOne(inversedBy: 'releves')]
    private ?Lieu $lieu_id = null;

    public function __construct()
    {
        $this->id_lieu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getReleveBrut(): ?string
    {
        return $this->releve_brut;
    }

    public function setReleveBrut(string $releve_brut): static
    {
        $this->releve_brut = $releve_brut;

        return $this;
    }

    /**
     * @return Collection<int, Lieu>
     */
    public function getIdLieu(): Collection
    {
        return $this->id_lieu;
    }

    public function addIdLieu(Lieu $idLieu): static
    {
        if (!$this->id_lieu->contains($idLieu)) {
            $this->id_lieu->add($idLieu);
            $idLieu->setReleves($this);
        }

        return $this;
    }

    public function removeIdLieu(Lieu $idLieu): static
    {
        if ($this->id_lieu->removeElement($idLieu)) {
            // set the owning side to null (unless already changed)
            if ($idLieu->getReleves() === $this) {
                $idLieu->setReleves(null);
            }
        }

        return $this;
    }

    public function getLieuId(): ?Lieu
    {
        return $this->lieu_id;
    }

    public function setLieuId(?Lieu $lieu_id): static
    {
        $this->lieu_id = $lieu_id;

        return $this;
    }
}
