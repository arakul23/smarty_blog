<?php

declare(strict_types=1);

use Index\Index;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/Index.php');

$index = new Index();
$index->index();
