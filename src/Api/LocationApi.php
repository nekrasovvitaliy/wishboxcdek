<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Location\GetCitiesRequest;
use WishboxCdek\Request\Location\GetCityByCoordinatesRequest;
use WishboxCdek\Request\Location\GetPostalcodesRequest;
use WishboxCdek\Request\Location\GetRegionsRequest;
use WishboxCdek\Request\Location\SuggestCitiesRequest;
use WishboxCdek\Response\Location\CityByCoordinatesDto;
use WishboxCdek\Response\Location\CityDto;
use WishboxCdek\Response\Location\PostalcodesDto;
use WishboxCdek\Response\Location\RegionDto;
use WishboxCdek\Response\Location\SuggestedCityDto;
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
        $response = $this->client->request('GET', '/v2/location/suggest/cities', $request->toArray());

        return array_map(
            static fn (array $city): SuggestedCityDto => SuggestedCityDto::fromArray($city),
            $response,
        );
    }

    /**
     * @return list<RegionDto>
     */
    public function getRegions(?GetRegionsRequest $request = null): array
    {
        $response = $this->client->request('GET', '/v2/location/regions', ($request ?? new GetRegionsRequest())->toArray());

        return array_map(
            static fn (array $region): RegionDto => RegionDto::fromArray($region),
            $response,
        );
    }

    public function getPostalcodes(GetPostalcodesRequest $request): PostalcodesDto
    {
        $response = $this->client->request('GET', '/v2/location/postalcodes', $request->toArray());

        return PostalcodesDto::fromArray($response);
    }

    public function getCityByCoordinates(GetCityByCoordinatesRequest $request): CityByCoordinatesDto
    {
        $response = $this->client->request('GET', '/v2/location/coordinates', $request->toArray());

        return CityByCoordinatesDto::fromArray($response);
    }

    /**
     * @return list<CityDto>
     */
    public function getCities(?GetCitiesRequest $request = null): array
    {
        $request ??= new GetCitiesRequest();
        $this->getCitiesRequestValidator->validate($request);

        $response = $this->client->request('GET', '/v2/location/cities', $request->toArray());

        return array_map(
            static fn (array $city): CityDto => CityDto::fromArray($city),
            $response,
        );
    }
}
