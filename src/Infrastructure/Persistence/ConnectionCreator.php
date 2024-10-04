<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        // Vamos colocar o diretório do nosso banco
        $databasePath = __DIR__ . '/../../../banco.sqlite';
        // Vamos estar fazendo uma conexão
        $connection = new PDO('sqlite:' . $databasePath);
        // Vamos estar mudando o tipo de erro que vai estar apresentado e mostrando um sobre o que esta acontecendo juntamente com o código de exceção
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Aqui irá configurar o modo como os dados vão ser retornados
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Retornar uma conexão
        return $connection;
    }
}
