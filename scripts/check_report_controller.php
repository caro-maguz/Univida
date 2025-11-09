<?php
require __DIR__ . '/../vendor/autoload.php';
$rc = new ReflectionClass('App\\Http\\Controllers\\ReporteController');
$methods = array_map(fn($m) => $m->name, $rc->getMethods());
echo "Methods on ReporteController:\n";
foreach ($methods as $name) echo $name . "\n";
var_export(method_exists('App\\Http\\Controllers\\ReporteController', 'createViolencia'));
echo PHP_EOL;
echo "Defined in file: ", $rc->getFileName(), PHP_EOL;
