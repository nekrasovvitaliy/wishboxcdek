<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Exception\ApiResponseException;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Exception\OrderValidationException;
use WishboxCdek\Request\Order\ContactDto;
use WishboxCdek\Request\Order\CreateOrderRequest;
use WishboxCdek\Request\Order\ItemRequestDto;
use WishboxCdek\Request\Order\LocationDto;
use WishboxCdek\Request\Order\MoneyDto;
use WishboxCdek\Request\Order\PackageRequestDto;
use WishboxCdek\Request\Order\PhoneDto;

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

$sender = new ContactDto(
    name: 'Wishbox Sender',
    phones: [
        new PhoneDto(number: '+79990000001'),
    ],
);

$recipient = new ContactDto(
    name: 'John Doe',
    phones: [
        new PhoneDto(number: '123'),
    ],
);

$packages = [
    new PackageRequestDto(
        number: 'PKG-1',
        weight: 1000,
        length: 10,
        width: 10,
        height: 10,
        items: [
            new ItemRequestDto(
                name: 'Test item',
                wareKey: 'SKU-1',
                payment: new MoneyDto(value: 0),
                cost: 1000,
                weight: 1000,
                amount: 1,
            ),
        ],
    ),
];

$request = CreateOrderRequest::make(
    tariffCode: 137,
    sender: $sender,
    recipient: $recipient,
    packages: $packages,
)
    ->withType(OrderType::INTERNET_SHOP)
    ->withNumber('ORDER-' . date('YmdHis'))
    ->withComment('Create order with invalid phone example')
    ->withFromLocation(new LocationDto(code: 44))
    ->withToLocation(new LocationDto(
        code: 137,
        address: 'Pushkina 1',
    ));

try {
    $createResponse = $client->orders()->create($request);
} catch (OrderValidationException $exception) {
    fwrite(STDERR, "Create order validation failed:" . PHP_EOL);
    foreach ($exception->getErrors() as $error) {
        fwrite(STDERR, "- {$error}" . PHP_EOL);
    }
    exit(1);
} catch (ApiResponseException $exception) {
    fwrite(STDERR, "Create order business error: " . $exception->getMessage() . PHP_EOL);
    foreach ($exception->getErrors() as $error) {
        fwrite(STDERR, sprintf("- [%s] %s%s", $error->code ?? 'n/a', $error->message ?? 'Unknown error', PHP_EOL));
    }
    exit(1);
} catch (HttpException $exception) {
    fwrite(STDERR, "Create order HTTP error: " . $exception->getMessage() . PHP_EOL);
    foreach ($exception->getErrors() as $error) {
        fwrite(STDERR, sprintf("- [%s] %s%s", $error->code ?? 'n/a', $error->message ?? 'Unknown error', PHP_EOL));
    }
    exit(1);
} catch (Throwable $exception) {
    fwrite(STDERR, "Create order unexpected error: " . $exception->getMessage() . PHP_EOL);
    exit(1);
}

$orderUuid = $createResponse->entity?->uuid;

printf("Created order UUID: %s%s", $orderUuid ?? 'n/a', PHP_EOL);
printf("Create request state: %s%s", $createResponse->requests[0]->state ?? 'unknown', PHP_EOL);

if ($orderUuid === null) {
    fwrite(STDERR, "Order UUID is missing in create response." . PHP_EOL);
    exit(1);
}

try {
    $orderDetails = $client->orders()->getByUuid($orderUuid);
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

printf("Fetched order UUID: %s%s", $orderDetails->entity?->uuid ?? 'n/a', PHP_EOL);

if (!$orderDetails->hasErrors()) {
    fwrite(STDOUT, "No order errors found." . PHP_EOL);
    exit(0);
}

foreach ($orderDetails->getErrors() as $error) {
    printf(
        "Phone error: [%s] %s%s",
        $error->code ?? 'n/a',
        $error->message ?? 'Unknown error',
        PHP_EOL,
    );
}
