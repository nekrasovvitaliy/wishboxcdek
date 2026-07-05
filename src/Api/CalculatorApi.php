<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Calculator\CalculateTariffWithServicesRequest;
use WishboxCdek\Request\Calculator\CalculatorRequestDto;
use WishboxCdek\Request\Calculator\CalculatorTariffListRequestDto;
use WishboxCdek\Response\Calculator\AvailableTariffsResponse;
use WishboxCdek\Response\Calculator\CalculateTariffResponse;
use WishboxCdek\Response\Calculator\CalculatorTariffListResponseDto;

final readonly class CalculatorApi
{
	public function __construct(private CdekClient $client)
	{
	}

	public function calculateTariffList(CalculatorTariffListRequestDto $request): CalculatorTariffListResponseDto
	{
		return CalculatorTariffListResponseDto::fromArray(
			$this->client->request('POST', '/v2/calculator/tarifflist', [], $request->toArray())
		);
	}

    public function calculateTariff(CalculatorRequestDto $request): CalculateTariffResponse
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
