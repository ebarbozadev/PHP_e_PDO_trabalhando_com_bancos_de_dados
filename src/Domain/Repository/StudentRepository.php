<?php

namespace Alura\Pdo\Domain\Repository;

use Alura\Pdo\Domain\Model\Student;

// Todas as classes que forem passadas como argumento devem ter essa interface
interface StudentRepository
{
    // Funções que vamos criar e o retorno
    public function allStudents(): array;
    public function studentsWithPhones(): array;
    public function studentsBirthAt(\DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}
