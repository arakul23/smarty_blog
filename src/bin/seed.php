<?php
declare(strict_types=1);

use App\Database\ConnectionFactory;
use App\Database\ConnectionRegistry;
use App\Service\SeederService;

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $connectionRegistry = new ConnectionRegistry(new ConnectionFactory());
    $seeder = new SeederService($connectionRegistry->getConnection());

    $seeder->seed();
    fwrite(STDOUT, "Database seeded successfully.\n");
    exit(0);
} catch (\Throwable $exception) {
    fwrite(STDERR, "Seeder failed: {$exception->getMessage()}\n");
    exit(1);
}
