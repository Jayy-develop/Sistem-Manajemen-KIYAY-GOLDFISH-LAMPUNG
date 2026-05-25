<?php
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PHP SAPI: " . php_sapi_name() . "\n";
echo "Extension Dir: " . ini_get('extension_dir') . "\n";
echo "\nLoaded Extensions:\n";
$exts = get_loaded_extensions();
sort($exts);
foreach ($exts as $ext) {
    echo "  - $ext\n";
}
echo "\nSQLite3 Loaded: " . (extension_loaded('sqlite3') ? "YES" : "NO") . "\n";
echo "SQLite3 Class: " . (class_exists('SQLite3') ? "EXISTS" : "NOT FOUND") . "\n";
?>
