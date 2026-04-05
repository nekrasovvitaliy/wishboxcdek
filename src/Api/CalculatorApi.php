<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Calculator\CalculateTariffListRequest;
use WishboxCdek\Request\Calculator\CalculateTariffRequest;
use WishboxCdek\Request\Calculator\CalculateTariffWithServicesRequest;
use WishboxCdek\Response\Calculator\AvailableTariffsResponse;
use WishboxCdek\Response\Calculator\CalculateTariffListResponse;
use WishboxCdek\Response\Calculator\CalculateTariffResponse;

final class CalculatorApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function calculateTariffList(CalculateTariffListRequest $request): CalculateTariffListResponse
    {
        return CalculateTariffListResponse::fromArray(
            $this->client->request('POST', '/v2/calculator/tarifflist', [], $request->toArray())
        );
    }

    public function calculateTariff(CalculateTariffRequest $request): CalculateTariffResponse
    {
        return CalculateTariffResponse::fromArray(
            $this->client->request('POST', '/v2/calculator/tariff', [], $request->toArray())
        );
    }

    public function calculateTariffWithServices(CalculateTariffWithServicesRequest $request): CalculateTariffResponse
    {
        return CalculateTariffResponse::fromArray(
            $this->client->request('POST', '/v2/calculator/tariffAndService', [], $request->toArray())
        );
    }

    public function getAvailableTariffs(): AvailableTariffsResponse
    {
        return AvailableTariffsResponse::fromArray(
            $this->client->request('GET', '/v2/calculator/alltariffs')
        );
    }
}
