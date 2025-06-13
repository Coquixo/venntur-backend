<?php

namespace App\Entity;

use App\Repository\ActividadRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActividadRepository::class)]
class Actividad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list', 'detail'])]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['list', 'detail'])]
    private ?string $nombre = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['list', 'detail'])]
    private ?string $descripcionCorta = null;

    #[ORM\Column(type: "text")]
    #[Groups(['detail'])]
    private ?string $descripcionLarga = null;

    #[ORM\Column(type: "float", nullable: true)]
    #[Groups(['list', 'detail'])]
    private ?float $precio = null;

    #[ORM\ManyToOne(targetEntity: Proveedor::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['list', 'detail'])]
    private ?Proveedor $proveedor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcionCorta(): ?string
    {
        return $this->descripcionCorta;
    }

    public function setDescripcionCorta(string $descripcionCorta): self
    {
        $this->descripcionCorta = $descripcionCorta;
        return $this;
    }

    public function getDescripcionLarga(): ?string
    {
        return $this->descripcionLarga;
    }

    public function setDescripcionLarga(string $descripcionLarga): self
    {
        $this->descripcionLarga = $descripcionLarga;
        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(?float $precio): self
    {
        $this->precio = $precio;
        return $this;
    }


    public function getProveedor(): ?Proveedor
    {
        return $this->proveedor;
    }

    public function setProveedor(?Proveedor $proveedor): self
    {
        $this->proveedor = $proveedor;
        return $this;
    }
}
