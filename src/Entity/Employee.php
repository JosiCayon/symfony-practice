<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;
// Esto es para añadir una restricción de que los datos sean únicos.
// Se añaden al nivel de clase
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; 

// Para las restricciones generales.
// Se añaden a nivel de propiedad
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @UniqueEntity("email", message="El email ya está en uso")
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * 
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 18,
     *     message = "El empleado debe ser mayor de edad"
     * )
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=128, unique=true)     
     * @Assert\Email(
     *     message = "'{{ value }}' no es un email válido."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
