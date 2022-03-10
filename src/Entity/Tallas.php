<?php

namespace App\Entity;

use App\Repository\TallasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TallasRepository::class)
 */
class Tallas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descTallas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescTallas(): ?string
    {
        return $this->descTallas;
    }

    public function setDescTallas(string $descTallas): self
    {
        $this->descTallas = $descTallas;

        return $this;
    }


}
