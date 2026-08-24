# Usar los scripts con XAMPP

Los dos scripts del repo (`validar.php` y `construir.php`) corren con **PHP CLI**,
que ya viene dentro de XAMPP. No hace falta instalar nada más ni usar Composer.

## El problema típico en Windows

Abrís la terminal, escribís `php scripts/validar.php` y te responde:

```
'php' no se reconoce como un comando interno o externo
```

Es porque XAMPP no agrega PHP al PATH del sistema. Tenés dos salidas.

### Opción A — Usar la ruta completa (rápido, sin configurar nada)

```bash
C:\xampp\php\php.exe scripts/validar.php
```

### Opción B — Agregar PHP al PATH (una sola vez)

1. Tecla Windows → buscar "variables de entorno"
2. **Variables de entorno** → en *Variables del sistema*, seleccionar `Path` → **Editar**
3. **Nuevo** → pegar `C:\xampp\php`
4. Aceptar todo y **cerrar y volver a abrir la terminal**

Verificá con:

```bash
php -v
```

En Linux o macOS con XAMPP, la ruta suele ser `/opt/lampp/bin/php`.

## Ver la página en tu máquina

Primero generá los datos:

```bash
php scripts/construir.php
```

Eso crea la carpeta `dist/` con `index.html` y `data.json`.

**Importante:** no abras `dist/index.html` con doble clic. La página lee `data.json`
con `fetch()`, y el navegador lo bloquea cuando el archivo se abre desde el disco
(protocolo `file://`). Tenés que servirla por HTTP.

### Con Apache de XAMPP

1. Copiá la carpeta `dist` dentro de `C:\xampp\htdocs\` y renombrala `recetario`
2. Abrí el **Panel de control de XAMPP** y arrancá **Apache**
3. Andá a `http://localhost/recetario/`

### Con el servidor propio de PHP (más simple, no necesita Apache)

```bash
php -S localhost:8000 -t dist
```

Y abrí `http://localhost:8000`.

> Ese comando levanta un servidor web mínimo que trae PHP. Para desarrollo alcanza
> y sobra; para producción se usa Apache o Nginx.

## Qué NO necesitás

- MySQL / MariaDB — el proyecto no usa base de datos
- phpMyAdmin
- Composer
- Ninguna extensión de PHP fuera de las que XAMPP trae activadas por defecto
