<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
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
    private $descColor;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescColor(): ?string
    {
        return $this->descColor;
    }

    public function setDescColor(string $descColor): self
    {
        $this->descColor = $descColor;

        return $this;
    }
}
