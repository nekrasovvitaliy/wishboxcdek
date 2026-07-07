<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AsyncRequestsReportDto
 */
final readonly class AsyncRequestsReportDto
{
    public mixed $ordersRequested;

    public mixed $ordersCreated;

    public mixed $requestsTotal;

    public mixed $requestsOk;

    public mixed $requestsNotOk;

    public mixed $requestsPerOrderMax;

    public mixed $requestsPerOrderMin;

    public mixed $requestsPerOrderAvg;

    public mixed $requestsOkPerOrderMax;

    public mixed $requestsOkPerOrderMin;

    public mixed $requestsOkPerOrderAvg;

    public mixed $requestsNotOkPerOrderMax;

    public mixed $requestsNotOkPerOrderMin;

    public mixed $requestsNotOkPerOrderAvg;

    public function __construct(
        mixed $ordersRequested = null,
        mixed $ordersCreated = null,
        mixed $requestsTotal = null,
        mixed $requestsOk = null,
        mixed $requestsNotOk = null,
        mixed $requestsPerOrderMax = null,
        mixed $requestsPerOrderMin = null,
        mixed $requestsPerOrderAvg = null,
        mixed $requestsOkPerOrderMax = null,
        mixed $requestsOkPerOrderMin = null,
        mixed $requestsOkPerOrderAvg = null,
        mixed $requestsNotOkPerOrderMax = null,
        mixed $requestsNotOkPerOrderMin = null,
        mixed $requestsNotOkPerOrderAvg = null,
    ) {
        $this->ordersRequested = $ordersRequested;
        $this->ordersCreated = $ordersCreated;
        $this->requestsTotal = $requestsTotal;
        $this->requestsOk = $requestsOk;
        $this->requestsNotOk = $requestsNotOk;
        $this->requestsPerOrderMax = $requestsPerOrderMax;
        $this->requestsPerOrderMin = $requestsPerOrderMin;
        $this->requestsPerOrderAvg = $requestsPerOrderAvg;
        $this->requestsOkPerOrderMax = $requestsOkPerOrderMax;
        $this->requestsOkPerOrderMin = $requestsOkPerOrderMin;
        $this->requestsOkPerOrderAvg = $requestsOkPerOrderAvg;
        $this->requestsNotOkPerOrderMax = $requestsNotOkPerOrderMax;
        $this->requestsNotOkPerOrderMin = $requestsNotOkPerOrderMin;
        $this->requestsNotOkPerOrderAvg = $requestsNotOkPerOrderAvg;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            ordersRequested: $data['ordersRequested'] ?? null,
            ordersCreated: $data['ordersCreated'] ?? null,
            requestsTotal: $data['requestsTotal'] ?? null,
            requestsOk: $data['requestsOk'] ?? null,
            requestsNotOk: $data['requestsNotOk'] ?? null,
            requestsPerOrderMax: $data['requestsPerOrderMax'] ?? null,
            requestsPerOrderMin: $data['requestsPerOrderMin'] ?? null,
            requestsPerOrderAvg: $data['requestsPerOrderAvg'] ?? null,
            requestsOkPerOrderMax: $data['requestsOkPerOrderMax'] ?? null,
            requestsOkPerOrderMin: $data['requestsOkPerOrderMin'] ?? null,
            requestsOkPerOrderAvg: $data['requestsOkPerOrderAvg'] ?? null,
            requestsNotOkPerOrderMax: $data['requestsNotOkPerOrderMax'] ?? null,
            requestsNotOkPerOrderMin: $data['requestsNotOkPerOrderMin'] ?? null,
            requestsNotOkPerOrderAvg: $data['requestsNotOkPerOrderAvg'] ?? null,
        );
    }
}
