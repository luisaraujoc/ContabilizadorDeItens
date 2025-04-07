<?php
spl_autoload_register(function ($class) {
    $prefixes = [
        'PhpOffice\\PhpSpreadsheet\\' => __DIR__ . '/src/PhpOffice/PhpSpreadsheet/',
        'Psr\\SimpleCache\\' => __DIR__ . '/src/Psr/SimpleCache/',
        'Composer\\Pcre\\' => __DIR__ . '/src/Composer/Pcre/',
        'ZipStream\\' => __DIR__ . '/src/ZipStream/'
    ];

    foreach ($prefixes as $prefix => $base_dir) {
        if (strpos($class, $prefix) === 0) {
            $file = $base_dir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});

// Configurações essenciais
require_once __DIR__ . '/src/PhpOffice/PhpSpreadsheet/Settings.php';
\PhpOffice\PhpSpreadsheet\Settings::setCache(null);

// Forçar uso do ZipStream0 (mais compatível)
class_alias(
    'PhpOffice\PhpSpreadsheet\Writer\ZipStream0',
    'PhpOffice\PhpSpreadsheet\Writer\ZipStream3'
);

// Inclua manualmente os arquivos essenciais
require_once __DIR__ . '/src/PhpOffice/PhpSpreadsheet/Spreadsheet.php';
require_once __DIR__ . '/src/PhpOffice/PhpSpreadsheet/Writer/Xlsx.php';
?>