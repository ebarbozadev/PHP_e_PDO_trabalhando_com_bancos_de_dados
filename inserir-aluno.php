<?php

require './vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

echo 'Conectado';

$student = new Student(null, 'Emanuel Barboza', new \DateTimeImmutable('2003-04-18'));
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";

var_dump($pdo->exec($sqlInsert));