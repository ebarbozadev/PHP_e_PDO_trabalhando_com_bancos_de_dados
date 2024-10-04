<?php

require './vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

// $statment = $pdo->query('SELECT * FROM students');
// var_dump($statment->fetchAll(PDO::FETCH_ASSOC));

// $statment = $pdo->query('SELECT * FROM students WHERE id >= 1');
// var_dump($statment->fetchAll(PDO::FETCH_ASSOC));

$statment = $pdo->query('SELECT * FROM students WHERE id = 1');
var_dump($statment->fetchColumn(1));