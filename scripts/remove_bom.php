<?php
$path = __DIR__ . '/../app/Http/Controllers/ReporteController.php';
$s = file_get_contents($path);
if (substr($s,0,3) === "\xEF\xBB\xBF") {
    file_put_contents($path, substr($s,3));
    echo "BOM removed\n";
} else {
    echo "No BOM found\n";
}
