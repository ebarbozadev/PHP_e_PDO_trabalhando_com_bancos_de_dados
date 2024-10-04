<?php

use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require './vendor/autoload.php';

$pdo = \Alura\Pdo\Infrastructure\Persistence\ConnectionCreator::createConnection();

// $statment = $pdo->query('SELECT * FROM students');
// var_dump($statment->fetchAll(PDO::FETCH_ASSOC));

// $statment = $pdo->query('SELECT * FROM students WHERE id >= 1');
// var_dump($statment->fetchAll(PDO::FETCH_ASSOC));

// $statment = $pdo->query('SELECT * FROM students WHERE id = 1');
$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();

var_dump($studentList);
