<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use DateTimeImmutable;
use PDO;
use RuntimeException;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {

        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        // Executa a query e armazena o resultado em $statment
        $statment = $this->connection->query('SELECT * FROM students;');

        // Armazena os resultados do fetchAll em uma variável
        $studentDataList = $statment->fetchAll($this->connection::FETCH_ASSOC);

        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date']),
            );
        }

        return $studentList;
    }

    public function studentsBirthAt(\DateTimeInterface $birthDate): array
    {
        $statment = $this->connection->prepare('SELECT * FROM students WHERE birth_date = ":birth_date";');
        $statment->bindValue(':birth_date', $birthDate->format('Y-m-d'), $this->connection::PARAM_STR);
        $statment->execute();

        return $statment->fetchAll();
    }

    public function save(Student $student): bool
    {
        if (is_null($student->id())) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $statment = $this->connection->prepare('INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);');

        $statment->bindValue(':name', $student->name(), $this->connection::PARAM_STR);
        $statment->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'), $this->connection::PARAM_STR);

        return $statment->execute();
    }

    private function update(Student $student): bool
    {
        $statment = $this->connection->prepare('UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;');
        $statment->bindValue(':name', $student->name(), $this->connection::PARAM_STR);
        $statment->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'), $this->connection::PARAM_STR);
        $statment->bindValue(':id', $student->id(), $this->connection::PARAM_INT);

        return $statment->execute();
    }

    public function remove(Student $student): bool
    {
        $statment = $this->connection->prepare('DELETE FROM students WHERE id = :id;');
        $statment->bindValue(':id', $student->id(), $this->connection::PARAM_INT);

        return $statment->execute();
    }

    public function studentsWithPhones(): array
    {
        $statment = $this->connection->prepare('
        SELECT 
            students.id AS student_id, 
            students.name, 
            students.birth_date, 
            phones.id AS phone_id, 
            phones.area_code, 
            phones.number 
        FROM students 
        INNER JOIN phones ON students.id = phones.student_id;
    ');
        $statment->execute();
        $result = $statment->fetchAll($this->connection::FETCH_ASSOC);

        $studentList = [];

        foreach ($result as $row) {
            // Se o estudante ainda não existir no array, cria o estudante
            if (!array_key_exists($row['student_id'], $studentList)) {
                $studentList[$row['student_id']] = new Student(
                    $row['student_id'],
                    $row['name'],
                    new DateTimeImmutable($row['birth_date'])
                );
            }

            // Adiciona o telefone ao estudante
            $phone = new Phone($row['phone_id'], $row['area_code'], $row['number']);
            $studentList[$row['student_id']]->addPhone($phone);
        }

        return $studentList;
    }
}
