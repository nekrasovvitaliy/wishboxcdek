<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Location\GetCitiesRequest;
use WishboxCdek\Request\Location\GetCityByCoordinatesRequest;
use WishboxCdek\Request\Location\GetPostalcodesRequest;
use WishboxCdek\Request\Location\GetRegionsRequest;
use WishboxCdek\Request\Location\SuggestCitiesRequest;
use WishboxCdek\Response\Error\SimplifiedResponseDto;
use WishboxCdek\Response\Location\CityByCoordinatesDto;
use WishboxCdek\Response\Location\PostalcodesDto;
use WishboxCdek\Response\Location\RegionDto;
use WishboxCdek\Response\Location\SuggestedCityDto;
use WishboxCdek\Response\Location\V2LocationCityDto;
use WishboxCdek\Validation\Location\GetCitiesRequestValidator;

final class LocationApi
{
    public function __construct(
        private readonly CdekClient $client,
        private readonly GetCitiesRequestValidator $getCitiesRequestValidator = new GetCitiesRequestValidator(),
    )
    {
    }

    /**
     * @return list<SuggestedCityDto>
     */
    public function suggestCities(SuggestCitiesRequest $request): array
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/location/suggest/cities',
            [
                200 => static fn ($response): array => array_map(
                    static fn (array $city): SuggestedCityDto => SuggestedCityDto::fromArray($city),
                    $response->data,
                ),
                400 => SimplifiedResponseDto::class,
            ],
            $request->toArray()
        );
    }

    /**
     * @return list<RegionDto>
     */
    public function getRegions(?GetRegionsRequest $request = null): array
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/location/regions',
            [
                200 => static fn ($response): array => array_map(
                    static fn (array $region): RegionDto => RegionDto::fromArray($region),
                    $response->data,
                ),
                400 => SimplifiedResponseDto::class,
            ],
            ($request ?? new GetRegionsRequest())->toArray()
        );
    }

    public function getPostalcodes(GetPostalcodesRequest $request): PostalcodesDto
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/location/postalcodes',
            [
                200 => PostalcodesDto::class,
                400 => SimplifiedResponseDto::class,
            ],
            $request->toArray()
        );
    }

    public function getCityByCoordinates(GetCityByCoordinatesRequest $request): CityByCoordinatesDto
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/location/coordinates',
            [
                200 => CityByCoordinatesDto::class,
                400 => SimplifiedResponseDto::class,
            ],
            $request->toArray()
        );
    }

    /**
     * @return list<V2LocationCityDto>
     */
    public function getCities(?GetCitiesRequest $request = null): array
    {
        $request ??= new GetCitiesRequest();
        $this->getCitiesRequestValidator->validate($request);

        return $this->client->requestMapped(
            'GET',
            '/v2/location/cities',
            [
                200 => static fn ($response): array => array_map(
                    static fn (array $city): V2LocationCityDto => V2LocationCityDto::fromArray($city),
                    $response->data,
                ),
                400 => SimplifiedResponseDto::class,
            ],
            $request->toArray()
        );
    }
}
