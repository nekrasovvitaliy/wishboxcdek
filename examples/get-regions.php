<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Request\Location\GetRegionsRequest;

require dirname(__DIR__) . '/vendor/autoload.php';

$account = getenv('CDEK_ACCOUNT') ?: null;
$password = getenv('CDEK_PASSWORD') ?: null;
$baseUrl = getenv('CDEK_BASE_URL') ?: CdekClient::SANDBOX_BASE_URL;

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

$regions = $client->locations()->getRegions(
    new GetRegionsRequest(countryCodes: 'RU', size: 10),
);

foreach ($regions as $region) {
    printf(
        "%s (%s)%s",
        $region->region ?? 'Unknown region',
        $region->countryCode ?? 'n/a',
        PHP_EOL,
    );
}
