<?php

require './vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$pdo = \Alura\Pdo\Infrastructure\Persistence\ConnectionCreator::createConnection();

$student = new Student(null, 'Edilson Carlos', new \DateTimeImmutable('2001-06-14'));
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";

var_dump($pdo->exec($sqlInsert));
