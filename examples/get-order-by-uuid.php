<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Exception\ApiExceptionInterface;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Exception\InvalidUuidException;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;

require __DIR__ . '/bootstrap.php';

$account = getenv('CDEK_ACCOUNT') ?: null;
$password = getenv('CDEK_PASSWORD') ?: null;
$baseUrl = getenv('CDEK_BASE_URL') ?: CdekClient::SANDBOX_BASE_URL;
$orderUuid = getenv('CDEK_ORDER_UUID') ?: null;

if ($account === null || $password === null) {
    fwrite(STDERR, "Set CDEK_ACCOUNT and CDEK_PASSWORD before running this example." . PHP_EOL);
    exit(1);
}

if ($orderUuid === null || $orderUuid === '') {
    fwrite(STDERR, "Set CDEK_ORDER_UUID before running this example." . PHP_EOL);
    exit(1);
}

$httpClient = new GuzzleClient();
$httpFactory = new HttpFactory();

$client = new CdekClient(
    $httpClient,
    $httpFactory,
    $httpFactory,
    [
        'base_url' => $baseUrl,
        'account' => $account,
        'password' => $password,
    ],
);

try {
    $response = $client->orders()->getByUuid($orderUuid);
} catch (InvalidUuidException $exception) {
    fwrite(STDERR, "Order UUID is invalid: " . $exception->getMessage() . PHP_EOL);
    exit(1);
} catch (ApiExceptionInterface $exception) {
    fwrite(STDERR, "CDEK returned an API error:" . PHP_EOL);
    $response = $exception->getResponse();

    if ($response instanceof SimplifiedResponseDto1) {
        foreach ($response->errors as $error) {
            fwrite(STDERR, sprintf("- [%s] %s%s", $error->code ?? 'n/a', $error->message ?? 'Unknown error', PHP_EOL));
        }
    } else {
        fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    }

    exit(1);
} catch (HttpException $exception) {
    fwrite(STDERR, "Get order HTTP error: " . $exception->getMessage() . PHP_EOL);
    foreach ($exception->getErrors() as $error) {
        fwrite(STDERR, sprintf("- [%s] %s%s", $error->code ?? 'n/a', $error->message ?? 'Unknown error', PHP_EOL));
    }
    exit(1);
} catch (Throwable $exception) {
    fwrite(STDERR, "Get order unexpected error: " . $exception->getMessage() . PHP_EOL);
    exit(1);
}

$order = $response->entity;
$lastStatus = $order->statuses[0] ?? null;

printf("Order UUID: %s%s", $order->uuid ?? 'n/a', PHP_EOL);
printf("CDEK number: %s%s", $order->cdekNumber ?? 'n/a', PHP_EOL);
printf("Order number: %s%s", $order->number ?? 'n/a', PHP_EOL);
printf("Tariff code: %s%s", $order->tariffCode !== null ? (string) $order->tariffCode : 'n/a', PHP_EOL);
printf("Status: %s%s", $lastStatus?->code ?? 'n/a', PHP_EOL);
printf("Sender: %s%s", $order->sender?->name ?? 'n/a', PHP_EOL);
printf("Recipient: %s%s", $order->recipient?->name ?? 'n/a', PHP_EOL);
printf("Packages: %d%s", count($order->packages), PHP_EOL);

foreach ($response->getWarnings() as $warning) {
    printf("Warning: [%s] %s%s", $warning->code ?? 'n/a', $warning->message ?? 'Unknown warning', PHP_EOL);
}

foreach ($response->getErrors() as $error) {
    printf("Error: [%s] %s%s", $error->code ?? 'n/a', $error->message ?? 'Unknown error', PHP_EOL);
}
