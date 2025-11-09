<?php
require __DIR__ . '/../vendor/autoload.php';
$class = \App\Http\Controllers\ReporteController::class;
$exists = method_exists($class, 'createViolencia');
echo $exists ? "yes\n" : "no\n";
