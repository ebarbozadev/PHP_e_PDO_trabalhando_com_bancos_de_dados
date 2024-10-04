<?php

require './vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$pdo = \Alura\Pdo\Infrastructure\Persistence\ConnectionCreator::createConnection();

$student = new Student(
    null,
    'Patrícia',
    new \DateTimeImmutable('1990-12-02')
);

// Vamos estar preparando uma inserção
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birthDate);";
$statment = $pdo->prepare($sqlInsert);
// Agora vamos passando no índice o que vai ter em cada parâmetro
// Isso no caso podemos fazer um INSERT, DELETE, DROP...
$statment->bindValue(':name', $student->name());
$statment->bindValue(':birthDate', $student->birthDate()->format('Y-m-d'));

if ($statment->execute()) {
    echo 'Aluno inserido com sucesso';
} else {
    echo 'Erro ao inserir o aluno';
}
