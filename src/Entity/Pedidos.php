<?php

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidosRepository::class)
 */
class Pedidos
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
    private $clienteSeccion;

    /**
     * @ORM\Column(type="integer")
     */
    private $productPedido;

    /**
     * @ORM\Column(type="integer")
     */
    private $tallaPedido;

    /**
     * @ORM\Column(type="integer")
     */
    private $colorPedido;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidadPedido;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClienteSeccion(): ?string
    {
        return $this->clienteSeccion;
    }

    public function setClienteSeccion(string $clienteSeccion): self
    {
        $this->clienteSeccion = $clienteSeccion;

        return $this;
    }

    public function getProductPedido()
    {
        return $this->productPedido;
    }

    public function setProductPedido($productPedido): void
    {
        $this->productPedido = $productPedido;
    }

    public function getTallaPedido()
    {
        return $this->tallaPedido;
    }

    public function setTallaPedido($tallaPedido): void
    {
        $this->tallaPedido = $tallaPedido;

    }

    public function getColorPedido()
    {
        return $this->colorPedido;
    }

    public function setColorPedido($colorPedido): void
    {
        $this->colorPedido = $colorPedido;

    }

    public function getCantidadPedido(): ?int
    {
        return $this->cantidadPedido;
    }

    public function setCantidadPedido(int $cantidadPedido): self
    {
        $this->cantidadPedido = $cantidadPedido;

        return $this;
    }

}
