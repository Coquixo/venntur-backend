<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
class Proveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list', 'detail'])]  // Permitimos serializar el id en listados y detalles
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['list', 'detail'])]  // Permitimos serializar el nombre en listados y detalles
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'proveedor', targetEntity: Actividad::class)]
    private Collection $actividades;

    public function __construct()
    {
        $this->actividades = new ArrayCollection();
    }

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

    /**
     * @return Collection|Actividad[]
     */
    public function getActividades(): Collection
    {
        return $this->actividades;
    }
}
