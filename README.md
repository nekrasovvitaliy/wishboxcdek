# wishbox/cdek-library

PHP 8.4 client for CDEK API with a modular structure around a shared `CdekClient`, PSR-18 HTTP support, request DTOs, and basic local validation for order creation.

## Requirements

- PHP 8.4+
- PSR-18 HTTP client
- PSR-17 request and stream factories

## Installation

```bash
composer require wishbox/cdek-library psr/http-client psr/http-factory psr/http-message
```

This package expects a PSR-18 HTTP client and PSR-17 factories from your application.

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\Calculator\CalculateTariffRequest;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Request\Intake\CreateIntakeRequest;
use WishboxCdek\Request\Location\GetCitiesRequest;
use WishboxCdek\Request\Location\GetRegionsRequest;
use WishboxCdek\Request\Order\CreateOrderRequest;
use WishboxCdek\Request\Order\OrderContact;
use WishboxCdek\Request\Order\OrderItemPayment;
use WishboxCdek\Request\Order\OrderLocation;
use WishboxCdek\Request\Order\OrderPackage;
use WishboxCdek\Request\Order\OrderPackageItem;
use WishboxCdek\Request\Order\OrderPhone;
use WishboxCdek\Request\Print\CreateOrdersPrintRequest;

$httpClient = new GuzzleClient();
$httpFactory = new HttpFactory();

$client = new CdekClient(
    $httpClient,
    $httpFactory,
    $httpFactory,
    [
        'base_url' => CdekClient::SANDBOX_BASE_URL,
        'account' => 'your-account',
        'password' => 'your-password',
    ]
);

$regions = $client->locations()->getRegions(new GetRegionsRequest(
    countryCodes: 'RU',
    size: 100,
));

$cities = $client->locations()->getCities(new GetCitiesRequest(
    countryCodes: 'RU',
    city: 'Moscow',
));

$deliveryPoints = $client->deliveryPoints()->getList(new GetDeliveryPointsRequest(
    cityCode: 44,
));

try {
    $order = $client->orders()->create(
        CreateOrderRequest::make(
            tariffCode: 139,
            sender: new OrderContact(
                name: 'Wishbox Sender',
                phones: [
                    new OrderPhone(number: '+79990000001'),
                ],
                contragentType: 'LEGAL_ENTITY',
            ),
            recipient: new OrderContact(
                name: 'John Doe',
                phones: [
                    new OrderPhone(number: '+79990000002'),
                ],
                email: 'john@example.com',
            ),
            packages: [
                new OrderPackage(
                    number: 'PKG-1',
                    weight: 1000,
                    length: 10,
                    width: 10,
                    height: 10,
                    items: [
                        new OrderPackageItem(
                            name: 'Test item',
                            wareKey: 'SKU-1',
                            payment: new OrderItemPayment(value: 1000),
                            cost: 1000,
                            weight: 1000,
                            amount: 1,
                        ),
                    ],
                ),
            ],
        )
            ->withType(OrderType::INTERNET_SHOP)
            ->withFromLocation(new OrderLocation(code: 44, address: 'Sender street 1'))
            ->withToLocation(new OrderLocation(code: 137, address: 'Recipient street 10'))
            ->withNumber('ORDER-1')
            ->withComment('Created from Wishbox SDK')
    );

    $orderDetails = $client->orders()->getByUuid($order->entity?->uuid ?? '');

    $intake = $client->intakes()->create(new CreateIntakeRequest([
        'order_uuid' => $order->entity?->uuid,
        'intake_date' => '2026-03-30',
        'intake_time_from' => '10:00',
        'intake_time_to' => '14:00',
    ]));

    $print = $client->prints()->createOrders(new CreateOrdersPrintRequest([
        'orders' => [
            ['order_uuid' => $order->entity?->uuid],
        ],
        'copy_count' => 2,
    ]));

    echo $order->entity?->uuid;
    echo $orderDetails->entity?->uuid;
    echo $intake->entity?->uuid;
    echo $print->requests[0]->state;
} catch (\WishboxCdek\Exception\OrderValidationException $e) {
    foreach ($e->getErrors() as $error) {
        echo $error . PHP_EOL;
    }
} catch (\WishboxCdek\Exception\ApiResponseException $e) {
    foreach ($e->getErrors() as $error) {
        echo $error->code . ': ' . $error->message . PHP_EOL;
    }
}
```

## Testing

```bash
composer test
composer test:integration
```

Current unit tests cover:

- request DTO serialization
- auth token request formatting
- authenticated request building
- automatic token fetch before API calls
- typed async responses for `orders()`, `intakes()`, and `prints()`
- typed order details response for `orders()->getByUuid()`
- local validation for `orders()->create()`

Current integration tests cover:

- `auth()->getOAuthToken()` wrong password handling against CDEK sandbox
- `locations()->getRegions()` against CDEK sandbox
- `locations()->getPostalcodes()` against CDEK sandbox
- `orders()->create()` against CDEK sandbox
- `orders()->getByUuid()` against CDEK sandbox

To run integration tests against sandbox, set:

```bash
CDEK_BASE_URL=https://api.edu.cdek.ru
CDEK_ACCOUNT=your-account
CDEK_PASSWORD=your-password
```

If credentials are missing, integration tests are skipped automatically.

## Structure

- `WishboxCdek\CdekClient` - config, auth, shared HTTP requests, PSR-18 integration
- `WishboxCdek\Api\AuthApi` - OAuth token
- `WishboxCdek\Api\LocationApi` - cities, regions, postal codes, coordinates
- `WishboxCdek\Api\DeliveryPointApi` - offices and pickup points
- `WishboxCdek\Api\CalculatorApi` - tariffs and cost calculation
- `WishboxCdek\Api\OrderApi` - create, update, get, delete orders
- `WishboxCdek\Api\IntakeApi` - intake dates and courier intake requests
- `WishboxCdek\Api\PrintApi` - order receipts, barcode print jobs, and barcode PDF downloads
- `WishboxCdek\Api\WebhookApi` - webhook subscriptions
- `WishboxCdek\Request\...` - request DTOs for all public API methods
- `WishboxCdek\Response\...` - response DTOs for typed API results
- `WishboxCdek\Validation\...` - local validators for request prechecks
- `WishboxCdek\Enum\...` - enums for documented CDEK constants

## Notes

- Production base URL: `https://api.cdek.ru`
- Sandbox base URL: `https://api.edu.cdek.ru`
- If `access_token` is not passed explicitly, the client will request it automatically using `account` and `password`
- Laravel facade `Http` is not PSR-18 by itself
- Joomla HTTP package can be used as a PSR-18 client
- `CreateOrderRequest` uses immutable fluent builder-style API: `make(...)` + `with...()`
- `OrderType::INTERNET_SHOP` and `OrderType::DELIVERY` map to the documented order types `ИМ` and `Доставка`
- `HttpException` handles transport and HTTP-level errors, `ApiResponseException` handles async business errors from successful CDEK responses with invalid `requests[*]`
- `OrderValidationException` is thrown before the HTTP call when local order validation fails
- Async methods like `orders()->create()`, `intakes()->create()`, `prints()->createOrders()`, and `prints()->createBarcodes()` return typed async response objects with `entity` and `requests`
- `orders()->getByUuid()` returns a typed `OrderDetails` object with `entity` and `extra`
- `prints()->downloadBarcodesPdf()` returns the raw PDF body for `/v2/print/barcodes/{uuid}.pdf`
- Built-in local validation currently knows destination rules for tariffs `136`, `137`, `138`, and `139`
