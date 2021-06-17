<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/amazing-employees", name="api_employees_")
 */
class ApiEmployeesController extends AbstractController
{
    /**
    * @Route(
    *   "", 
    *   name="cget",
    *   methods={"GET"}
    *)
    */
    public function index(Request $request, EmployeeRepository $employeeRepository): Response
    {
        if($request->query->has('term')) {
            $people = $employeeRepository->findByTerm($request->query->get('term'));

            return $this->json($people);
        }
        return $this->json($employeeRepository->findAll());
    }

    /**
    * @Route(
    *    "/{id}", 
    *    name="get",
    *    methods={"GET"},
    *    requirements={
    *       "id": "\d+"
    *    }
    *)
    */
    public function show(Employee $employee): Response
    {
        return $this->json($employee);
    }

    /**
    * @Route(
    *    "", 
    *    name="post",
    *    methods={"POST"}
    *)
    */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {

        $data = $request->request;
        
        //Creamos un nuevo objeto para enviar en la solicitud
        $employee = new Employee();
        $employee->setName($data->get('name'));
        $employee->setEmail($data->get('email'));
        $employee->setAge($data->get('age'));
        $employee->setCity($data->get('city'));
        $employee->setPhone($data->get('phone'));

        //Ahora pasamos el objeto a la BBDD
        $entityManager->persist($employee);
        $entityManager->flush();

        dump($employee);

        return $this->json(
            $employee,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_employees_get', 
                    [
                        'id' => $employee->getId()
                    ]
                )
            ]
        );
    }


    /**
    * @Route(
    *    "/{id}", 
    *    name="put",
    *    methods={"PUT"},
    *    requirements={
    *       "id": "\d+"
    *    }
    *)
    */
    public function update(int $id): Response
    {
        return $this->json([
            'method' => 'PUT',
            'description' => 'Actualiza un recurso empleado con id: '.$id.'.'
        ]);
    }


    /**
    * @Route(
    *    "/{id}", 
    *    name="delete",
    *    methods={"DELETE"},
    *    requirements={
    *       "id": "\d+"
    *    }
    *)
    */
    public function delete(int $id): Response
    {
        return $this->json([
            'method' => 'DELETE',
            'description' => 'Elimina un recurso empleado con id: '.$id.'.'
        ]);
    }

}
