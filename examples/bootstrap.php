<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$envFile = dirname(__DIR__) . '/.env.integration';

if (!is_file($envFile)) {
    return;
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($lines === false) {
    return;
}

foreach ($lines as $line) {
    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#')) {
        continue;
    }

    $separatorPosition = strpos($line, '=');

    if ($separatorPosition === false) {
        continue;
    }

    $name = trim(substr($line, 0, $separatorPosition));
    $value = trim(substr($line, $separatorPosition + 1));

    if ($name === '' || getenv($name) !== false) {
        continue;
    }

    if (
        (str_starts_with($value, '"') && str_ends_with($value, '"'))
        || (str_starts_with($value, '\'') && str_ends_with($value, '\''))
    ) {
        $value = substr($value, 1, -1);
    }

    putenv(sprintf('%s=%s', $name, $value));
    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}
