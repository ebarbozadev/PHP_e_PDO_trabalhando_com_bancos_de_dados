<?php

require './vendor/autoload.php';

$pdo = \Alura\Pdo\Infrastructure\Persistence\ConnectionCreator::createConnection();

$prepareStatment = $pdo->prepare('DELETE FROM students WHERE id = :id');
$prepareStatment->bindValue(':id', 4, PDO::PARAM_INT);
var_dump($prepareStatment->execute());
