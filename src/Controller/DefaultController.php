<?php

declare(strict_types=1);

// El namespace será App\NombreCarpetaQueEstamos
namespace App\Controller;

// Esto lo importa automáticamente al declarar Response en la clase
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $solicitud): Response 
    {
        echo '<pre>query: ida:'; var_dump($solicitud->query->get('ida', '100')); echo '</pre>';
        echo '<pre>query: id:'; var_dump($solicitud->query->get('id', '100')); echo '</pre>';

        // Por defecto debe ser un objeto de la clase: Response (Symfony\Component\HttpFoundation)
        // render() es un método hereado de AbstractController
        // que devuelve el contenido declarado en una plantillas de Twig.
        // https://twig.symfony.com/doc/3.x/templates.html

        //Lo primero es la vista y lo segundo los parámetros.
        //Los parámetros van como un array asociativo
        return $this->render('default/index.html.twig', [
            'people'=>self::PEOPLE
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
     * @Route(
        * "/default.{_format}", 
        * name="default_index_json",
        * requirements = {
        *      "_format": "json"
        * }
     * )
     * 
     * El comando:
     * symfony console router:match /default.json
     * buscará la acción coincidente con la ruta indicada
     * y mostrará la información asociada.
     * 
     */
    public function indexJson(): JsonResponse {
        return new JsonResponse(self::PEOPLE);
        //return this->json(self::PEOPLE); Esto es una sintaxis alternativa
    }


    /** 
    * @Route(
    *    "/default/{id}", 
    *    name="default_show",
    *    requirements = {
    *        "id": "[0-3]"
    *    }
    *  )
    */
    public function show(int $id): Response {
        return $this->render('default/show.html.twig', [
            'id' => $id,
            'person' => self::PEOPLE[$id]
            ]);
    }
}