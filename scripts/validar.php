<?php
/**
 * Valida todos los aportes de comandos/.
 * Uso: php scripts/validar.php
 * Solo necesita PHP CLI. Sin Composer, sin dependencias.
 */

/** Largo en caracteres, sin depender de la extensión mbstring. */
function largo(string $t): int {
    return preg_match_all('/./us', $t);
}

/** Minúsculas seguras para comparar, sin depender de mbstring. */
function normalizar(string $t): string {
    return strtolower(trim($t));
}

$DIR          = __DIR__ . '/../comandos';
$OBLIGATORIOS = ['comando', 'categoria', 'que_hace', 'ejemplo', 'cuidado', 'autor'];
$CATEGORIAS   = ['basico', 'ramas', 'remoto', 'historia', 'deshacer', 'tags', 'inspeccion'];

$errores = [];
$vistos  = [];

$archivos = glob($DIR . '/*.json');
sort($archivos);

if (count($archivos) === 0) {
    $errores[] = 'No hay ningún aporte en comandos/';
}

foreach ($archivos as $ruta) {
    $nombre = basename($ruta);
    $slug   = basename($ruta, '.json');

    $dato = json_decode(file_get_contents($ruta), true);

    if ($dato === null) {
        $errores[] = "comandos/$nombre: el JSON no se puede leer — " . json_last_error_msg();
        continue;
    }

    foreach ($OBLIGATORIOS as $campo) {
        if (!isset($dato[$campo]) || !is_string($dato[$campo]) || trim($dato[$campo]) === '') {
            $errores[] = "comandos/$nombre: falta el campo \"$campo\" o está vacío";
        }
    }

    if (isset($dato['categoria']) && !in_array($dato['categoria'], $CATEGORIAS, true)) {
        $errores[] = "comandos/$nombre: categoría \"{$dato['categoria']}\" no permitida. Usá: "
                   . implode(', ', $CATEGORIAS);
    }

    if (isset($dato['autor']) && $dato['autor'] !== $slug) {
        $errores[] = "comandos/$nombre: el campo \"autor\" ({$dato['autor']}) tiene que coincidir "
                   . "con el nombre del archivo ($slug)";
    }

    if (isset($dato['que_hace']) && largo($dato['que_hace']) > 160) {
        $errores[] = "comandos/$nombre: \"que_hace\" supera los 160 caracteres";
    }

    if (isset($dato['comando'])) {
        $clave = normalizar($dato['comando']);
        if (isset($vistos[$clave])) {
            $errores[] = "comandos/$nombre: el comando \"{$dato['comando']}\" ya fue documentado "
                       . "en {$vistos[$clave]}";
        } else {
            $vistos[$clave] = "comandos/$nombre";
        }
    }
}

if (count($errores) > 0) {
    fwrite(STDERR, "\nValidación fallida — " . count($errores) . " problema(s):\n\n");
    foreach ($errores as $e) {
        fwrite(STDERR, "  [X] $e\n");
    }
    fwrite(STDERR, "\n");
    exit(1);
}

echo 'Validación OK — ' . count($archivos) . " comando(s) sin errores.\n";
