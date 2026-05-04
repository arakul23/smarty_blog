<?php

declare(strict_types=1);

use App\Container\AppContainer;

require_once(__DIR__ . '/../vendor/autoload.php');

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

$container = new AppContainer();
$categoryArticles = $container->getCategoryArticles();
$categoryId = (int)($_GET['category'] ?? 0);
$sort = (string)($_GET['sort'] ?? 'date');
$page = max(1, (int)($_GET['page'] ?? 1));

if (!in_array($sort, ['date', 'views'], true)) {
    $sort = 'date';
}

$categoryArticles->categoryArticles($categoryId, $sort, $page);
