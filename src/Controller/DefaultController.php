<?php

declare(strict_types=1);

// El namespace será App\NombreCarpetaQueEstamos
namespace App\Controller;

// Esto lo importa automáticamente al declarar Response en la clase

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Hay que importar este Route
use Symfony\Component\Routing\Annotation\Route;

// La clase se debe llamar igual que el fichero
// AbstractController pone a nuestra disposición varias funciones
class DefaultController extends AbstractController {
 

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
        // Por defecto debe ser un objeto de la clase: Response (Symfony\Component\HttpFoundation)
        // render() es un método hereado de AbstractController
        // que devuelve el contenido declarado en una plantillas de Twig.
        // https://twig.symfony.com/doc/3.x/templates.html

        //Lo primero es la vista y lo segundo los parámetros.
        //Los parámetros van como un array asociativo
        
        $orm = $this->getDoctrine();
        $repo = $orm->getRepository(Employee::class);
        $people = $repo->findAll();
        return $this->render('default/index.html.twig', [
            'people'=>$people
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
        return new JsonResponse([]);
        //return $this->json([]); Esto es una sintaxis alternativa
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
            'person' => [][$id]
            ]);
    }


    /** 
    * @Route(
    *    "/default/{id}.{_format}", 
    *    name="default_show_json",
    *    requirements = {
    *        "id": "[0-3]",
    *        "_format": "json"
    *    }
    *  )
    */
    public function showJson(int $id): JsonResponse {
        $person = [][$id];
        return new JsonResponse($person);
    }

    /**
    * @Route(
    * "/default.{_format}", 
    * name="default_show_json_request",
    * requirements = {
    *      "_format": "json"
    * })
    */
    public function indexJsonRequest(Request $request): JsonResponse {
        $data = $request->query->has('id') ? [][$request->query->get('id')] : [];
        return $this->json($data);
    }

    /**
     * @Route(
     *      "/redirect-to-home",
     *      name = "default_redirect_to_home"
     *  )
     */
    public function redirectToHome(): Response {
        // Redirigir a la URL /default
        return $this->redirect('/default');

        // Redirigir a una ruta utilizando su nombre
        // return $this->redirectToRoute('default_show', ['id' => 1]);

       
    }
}