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
use WishboxCdek\Response\Error\SimplifiedResponseDto1;

final readonly class CalculatorApi
{
	public function __construct(private CdekClient $client)
	{
	}

	public function calculateTariffList(CalculatorTariffListRequestDto $request): CalculatorTariffListResponseDto
	{
		return $this->client->requestMapped(
			'POST',
			'/v2/calculator/tarifflist',
			[
				200 => CalculatorTariffListResponseDto::class,
				400 => SimplifiedResponseDto1::class,
			],
			[],
			$request->toArray()
		);
	}

    public function calculateTariff(CalculatorRequestDto $request): CalculateTariffResponse
	{
		return $this->client->requestMapped(
			'POST',
			'/v2/calculator/tariff',
			[
				200 => CalculateTariffResponse::class,
				400 => SimplifiedResponseDto1::class,
			],
			[],
			$request->toArray()
		);
	}

	public function calculateTariffWithServices(CalculateTariffWithServicesRequest $request): CalculateTariffResponse
	{
		return $this->client->requestMapped(
			'POST',
			'/v2/calculator/tariffAndService',
			[
				200 => CalculateTariffResponse::class,
				400 => SimplifiedResponseDto1::class,
			],
			[],
			$request->toArray()
		);
	}

	public function getAvailableTariffs(): AvailableTariffsResponse
	{
		return $this->client->requestMapped(
			'GET',
			'/v2/calculator/alltariffs',
			[
				200 => AvailableTariffsResponse::class,
				400 => SimplifiedResponseDto1::class,
			]
		);
	}
}
