<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $commune = null;

    #[ORM\Column(length: 5)]
    private ?string $code_postal = null;

    #[ORM\OneToMany(mappedBy: 'lieu_id', targetEntity: Releves::class)]
    private Collection $releves;

    public function __construct()
    {
        $this->releves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Releves>
     */
    public function getReleves(): Collection
    {
        return $this->releves;
    }

    public function addReleve(Releves $releve): static
    {
        if (!$this->releves->contains($releve)) {
            $this->releves->add($releve);
            $releve->setLieuId($this);
        }

        return $this;
    }

    public function removeReleve(Releves $releve): static
    {
        if ($this->releves->removeElement($releve)) {
            // set the owning side to null (unless already changed)
            if ($releve->getLieuId() === $this) {
                $releve->setLieuId(null);
            }
        }

        return $this;
    }
}
