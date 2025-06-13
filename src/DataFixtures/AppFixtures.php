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
            $this->passwordHasher->hashPassword($user, 'admin')
        );
        $manager->persist($user);

        // Crear Proveedores
        $proveedor1 = new Proveedor();
        $proveedor1->setNombre('Booking.com');
        $manager->persist($proveedor1);

        $proveedor2 = new Proveedor();
        $proveedor2->setNombre('SMY Travel');
        $manager->persist($proveedor2);

        // Actividades con y sin precio

        $actividad1 = new Actividad();
        $actividad1->setNombre('Hotel Islas Baleares');
        $actividad1->setDescripcionCorta('Hotel de lujo en las Islas Baleares con vistas al mar');
        $actividad1->setDescripcionLarga('Disfruta de una estancia inolvidable en nuestro hotel de lujo en las Islas Baleares. Con vistas espectaculares al mar, este hotel ofrece todas las comodidades que necesitas para relajarte y disfrutar de tus vacaciones.');
        $actividad1->setPrecio(50);
        $actividad1->setProveedor($proveedor1);
        $manager->persist($actividad1);

        $actividad2 = new Actividad();
        $actividad2->setNombre('Vuelo Mediterráneo');
        $actividad2->setDescripcionCorta('1 hora de vuelo en globo sobre la costa mediterránea');
        $actividad2->setDescripcionLarga('Disfruta de una experiencia única volando en globo sobre la hermosa costa mediterránea. Esta actividad incluye un vuelo de 1 hora, con vistas espectaculares y un brindis al aterrizar.');
        $actividad2->setPrecio(100);
        $actividad2->setProveedor($proveedor2);
        $manager->persist($actividad2);

        $actividad3 = new Actividad();
        $actividad3->setNombre('Excursión a la montaña');
        $actividad3->setDescripcionCorta('Excursión guiada de 3 horas por la montaña');
        $actividad3->setDescripcionLarga('Únete a nosotros en una emocionante excursión guiada de 3 horas por la montaña. Disfruta de la naturaleza, aprende sobre la flora y fauna local, y captura vistas impresionantes.');
        $actividad3->setPrecio(150);
        $actividad3->setProveedor($proveedor2);
        $manager->persist($actividad3);

        $actividad4 = new Actividad();
        $actividad4->setNombre('Paseo por la muralla china');
        $actividad4->setDescripcionCorta('Paseo guiado de no guiado por la muralla china');
        $actividad4->setDescripcionLarga('Explora la majestuosa Muralla China a tu propio ritmo. Este paseo no guiado te permite disfrutar de las vistas y la historia de una de las maravillas del mundo a tu manera.');
        // Sin proveedor ni precio
        $actividad4->setPrecio(null);
        $manager->persist($actividad4);

        // Nuevas actividades:

        $actividad5 = new Actividad();
        $actividad5->setNombre('Tour gastronómico en París');
        $actividad5->setDescripcionCorta('Descubre la cocina francesa en un tour guiado');
        $actividad5->setDescripcionLarga('Un recorrido por los mejores restaurantes y mercados de París, degustando especialidades locales y aprendiendo sobre la cultura gastronómica francesa.');
        $actividad5->setPrecio(120);
        $actividad5->setProveedor($proveedor1);
        $manager->persist($actividad5);

        $actividad6 = new Actividad();
        $actividad6->setNombre('Clase de yoga al aire libre');
        $actividad6->setDescripcionCorta('Sesión de yoga en el parque central');
        $actividad6->setDescripcionLarga('Relájate y conecta con la naturaleza en una clase de yoga al aire libre, apta para todos los niveles.');
        // Sin precio (gratis)
        $actividad6->setPrecio(0);
        $actividad6->setProveedor($proveedor2);
        $manager->persist($actividad6);

        $actividad7 = new Actividad();
        $actividad7->setNombre('Tour histórico por Roma');
        $actividad7->setDescripcionCorta('Visita guiada por los monumentos históricos');
        $actividad7->setDescripcionLarga('Explora la historia de Roma visitando el Coliseo, el Foro Romano, y otros sitios emblemáticos con un guía experto.');
        $actividad7->setPrecio(75);
        $actividad7->setProveedor($proveedor1);
        $manager->persist($actividad7);

        $actividad8 = new Actividad();
        $actividad8->setNombre('Clase de pintura para niños');
        $actividad8->setDescripcionCorta('Actividad creativa para niños de 5 a 12 años');
        $actividad8->setDescripcionLarga('Fomenta la creatividad de los niños con una divertida clase de pintura, materiales incluidos.');
        // Sin precio definido
        $actividad8->setPrecio(null);
        $actividad8->setProveedor($proveedor2);
        $manager->persist($actividad8);

        $manager->flush();
    }
}
