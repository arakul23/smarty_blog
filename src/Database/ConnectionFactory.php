<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

class ConnectionFactory
{
    public function create(): PDO
    {
        $host = (string) (getenv('DATABASE_HOST') ?: '127.0.0.1');
        $port = (string) (getenv('DATABASE_PORT') ?: '3306');
        $database = (string) (getenv('DATABASE_NAME') ?: 'smarty_blog');
        $user = (string) (getenv('DATABASE_USER') ?: 'root');
        $password = (string) (getenv('DATABASE_PASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD') ?: 'root');

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $host,
            $port,
            $database
        );

        try {
            return new PDO(
                $dsn,
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $exception) {
            throw new RuntimeException(
                'Could not connect to database: ' . $exception->getMessage(),
                (int) $exception->getCode(),
                $exception
            );
        }
    }
}
