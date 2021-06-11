<?php

declare(strict_types=1);

// El namespace será App\NombreCarpetaQueEstamos
namespace App\Controller;

// Esto lo importa automáticamente al declarar Response en la clase
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

// Hay que importar este Route
use Symfony\Component\Routing\Annotation\Route;

// La clase se debe llamar igual que el fichero
// AbstractController pone a nuestra disposición varias funciones
class DefaultController extends AbstractController {


    const PEOPLE = [
        ['name' => 'Carlos', 'email' => 'carlos@correo.com', 'age' => 30, 'city' => 'Benalmádena'],
        ['name' => 'Carmen', 'email' => 'carmen@correo.com', 'age' => 25, 'city' => 'Fuengirola'],
        ['name' => 'Carmelo', 'email' => 'carmelo@correo.com', 'age' => 35, 'city' => 'Torremolinos'],
        ['name' => 'Carolina', 'email' => 'carolina@correo.com', 'age' => 38, 'city' => 'Málaga'],        
    ];
    

    /**
     * @Route("/default", name="default_index")
     * 
     * El primer parámetro de Route es la URL a la que
     * queremos asociar la acción y lo segundo es el nombre
     * que queremos dar a la ruta.
    */

    // Debe tener un método público que siempre debe devolver algo
    public function index(): Response 
    {
        // Por defecto debe ser un objeto de la clase: Response (Symfony\Component\HttpFoundation)
        // render() es un método hereado de AbstractController
        // que devuelve el contenido declarado en una plantillas de Twig.
        // https://twig.symfony.com/doc/3.x/templates.html

        $name = 'Luis';

        //Lo primero es la vista y lo segundo los parámetros.
        //Los parámetros van como un array asociativo
        return $this->render('default/index.html.twig', [
            'nombre'=>$name
        ]);        
    }

    /** 
    * @Route("/saludar", name="default_saludar")
    */
    public function saludar(): Response 
    {
        return new Response('<html><body>hola</body></html>');
    }


    /**
     * @Route("/json", name="default_index_json")
     */
    public function indexJson(): JsonResponse {
        return new JsonResponse(self::PEOPLE);
    }

}