<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;

require dirname(__DIR__) . '/vendor/autoload.php';

$account = getenv('CDEK_ACCOUNT') ?: null;
$password = getenv('CDEK_PASSWORD') ?: null;
$baseUrl = getenv('CDEK_BASE_URL') ?: CdekClient::SANDBOX_BASE_URL;
$cityCode = getenv('CDEK_CITY_CODE') ?: '44';

if ($account === null || $password === null) {
    fwrite(STDERR, "Set CDEK_ACCOUNT and CDEK_PASSWORD before running this example." . PHP_EOL);
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

$request = new GetDeliveryPointsRequest(
    cityCode: (int) $cityCode,
    isHandout: true,
    size: 10,
);

try {
    $deliveryPoints = $client->deliveryPoints()->getList($request);
} catch (HttpException $exception) {
    fwrite(STDERR, 'Delivery points request failed: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}

foreach ($deliveryPoints as $deliveryPoint) {
    printf(
        "[%s] %s | %s | cashless: %s%s",
        $deliveryPoint->code ?? 'n/a',
        $deliveryPoint->name ?? 'Unknown office',
        $deliveryPoint->location?->address ?? 'Address is not available',
        ($deliveryPoint->haveCashless ?? false) ? 'yes' : 'no',
        PHP_EOL,
    );
}
