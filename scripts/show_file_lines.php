<?php
$lines = file(__DIR__ . '/../app/Http/Controllers/ReporteController.php');
foreach ($lines as $i => $line) {
    $num = $i+1;
    printf("%4d: %s", $num, $line);
}
