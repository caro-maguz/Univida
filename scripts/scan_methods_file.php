<?php
$src = file_get_contents(__DIR__ . '/../app/Http/Controllers/ReporteController.php');
echo "File size: " . strlen($src) . "\n";
// crude regex to find function names
preg_match_all('/function\s+([a-zA-Z0-9_]+)\s*\(/', $src, $m);
echo "Functions found in file: \n";
print_r($m[1]);
?>