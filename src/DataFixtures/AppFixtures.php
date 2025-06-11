<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Proveedor;
use App\Entity\Actividad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Crear Usuarios
        $user = new User();
        $user->setEmail('contact@alexlopez.net');
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'alexlopez')
        );
        $manager->persist($user);

        // Crear Proveedores
        $proveedor1 = new Proveedor();
        $proveedor1->setNombre('Proveedor A');
        $manager->persist($proveedor1);

        $proveedor2 = new Proveedor();
        $proveedor2->setNombre('Proveedor B');
        $manager->persist($proveedor2);

        // Crear Actividades con y sin proveedor
        $actividad1 = new Actividad();
        $actividad1->setNombre('Actividad 1');
        $actividad1->setDescripcionCorta('Descripción corta 1');
        $actividad1->setDescripcionLarga('Descripción larga y detallada de la actividad 1');
        $actividad1->setPrecio(100);
        $actividad1->setProveedor($proveedor1);
        $manager->persist($actividad1);

        $actividad2 = new Actividad();
        $actividad2->setNombre('Actividad 2');
        $actividad2->setDescripcionCorta('Descripción corta 2');
        $actividad2->setDescripcionLarga('Descripción larga y detallada de la actividad 2');
        $actividad2->setPrecio(150);
        $actividad2->setProveedor($proveedor2);
        $manager->persist($actividad2);

        $actividad3 = new Actividad();
        $actividad3->setNombre('Actividad sin proveedor');
        $actividad3->setDescripcionCorta('Descripción corta sin proveedor');
        $actividad3->setDescripcionLarga('Descripción larga sin proveedor asignado');
        $actividad3->setPrecio(80);
        // No asignamos proveedor para esta
        $manager->persist($actividad3);

        $manager->flush();
    }
}
