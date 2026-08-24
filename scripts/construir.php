<?php
/**
 * Junta todos los aportes en un solo data.json y arma dist/ para publicar.
 * Uso: php scripts/construir.php
 */

$raiz    = __DIR__ . '/..';
$version = getenv('VERSION') ?: 'dev';

$comandos = [];
foreach (glob($raiz . '/comandos/*.json') as $ruta) {
    $comandos[] = json_decode(file_get_contents($ruta), true);
}

usort($comandos, fn($a, $b) => strcmp($a['comando'], $b['comando']));

if (!is_dir($raiz . '/dist')) {
    mkdir($raiz . '/dist', 0777, true);
}

copy($raiz . '/web/index.html', $raiz . '/dist/index.html');

file_put_contents(
    $raiz . '/dist/data.json',
    json_encode(
        [
            'version'  => $version,
            'generado' => date('c'),
            'comandos' => $comandos,
        ],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    )
);

echo 'Build listo — ' . count($comandos) . " comando(s), versión $version.\n";
