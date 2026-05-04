<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

class ConnectionRegistry
{
    private ?PDO $pdo = null;

    public function __construct(private readonly ConnectionFactory $factory)
    {}

    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = $this->factory->create();
        }

        return $this->pdo;
    }
}
