<?php

declare(strict_types=1);

// El namespace será App\NombreCarpetaQueEstamos
namespace App\Controller;

// Esto lo importa automáticamente al declarar Response en la clase

use App\Repository\EmployeeRepository;
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
    public function index(Request $request, EmployeeRepository $employeeRepository): Response 
    {

        if($request->query->has('term')) {
            $people = $employeeRepository->findByTerm($request->query->get('term'));
            
            return $this->render('default/index.html.twig', [
                'people'=>$people
                ]);    
        }



        // Por defecto debe ser un objeto de la clase: Response (Symfony\Component\HttpFoundation)
        // render() es un método hereado de AbstractController
        // que devuelve el contenido declarado en una plantillas de Twig.
        // https://twig.symfony.com/doc/3.x/templates.html

        //Lo primero es la vista y lo segundo los parámetros.
        //Los parámetros van como un array asociativo
        
        // Metodo 1: Accediendo al repositorio a través de AbstractController
        // $people = $this->getDoctrine()->getRepository(Employee::class)->findAll();
        
        // Método 2: Accediendo al parámetro indicando el tipo (type hint).
        $order = [];
        if($request->query->has('orderBy')) {
            $order[$request->query->get('orderBy')] = $request->query->get('orderDir', 'ASC');
        }
        $people = $employeeRepository->findBy([], $order);

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
    public function indexJson(EmployeeRepository $employeeRepository): JsonResponse {
        $people = $employeeRepository->findAll();
        return $this->json($people);
    }


    /** 
    * @Route(
    *    "/default/{id}", 
    *    name="default_show",
    *    requirements = {
    *        "id": "\d+"
    *    }
    *  )
    */
    public function show(int $id, EmployeeRepository $employeeRepository): Response {
        $data = $employeeRepository->find($id);
        return $this->render('default/show.html.twig', [
            'id' => $id,
            'person' => $data
            ]);
    }

    // La técinca ParamConverte inyecta directamente,
    // un objeto del tipo indicado como parámetro
    // intentando hacer un match del parámetro de la ruta
    // con alguna de las propiedades del objeto requerido.
    //Esto es similar a lo anterior
    /*     public function show(Employee $employee): Response {
        return $this->render('default/show.html.twig', [
            'person' => $employee
        ]);
    } */




    /** 
    * @Route(
    *    "/default/{id}.{_format}", 
    *    name="default_show_json",
    *    requirements = {
    *        "id": "\d+",
    *        "_format": "json"
    *    }
    *  )
    */
    public function showJson(int $id, EmployeeRepository $employeeRepository): JsonResponse {
        $data = $employeeRepository->find($id);
        return $this->json($data);
    }

    /**
    * @Route(
    * "/default.{_format}", 
    * name="default_show_json_request",
    * requirements = {
    *      "_format": "json"
    * })
    */
    public function indexJsonRequest(Request $request, EmployeeRepository $employeeRepository): JsonResponse {
        $data = $request->query->has('id') ? 
            $employeeRepository->find($request->query->get('id')) :
            $employeeRepository->findAll();

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