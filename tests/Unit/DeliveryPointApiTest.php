<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\Language;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxCdek\CdekClient;
use WishboxCdek\Request\DeliveryPoint\GetDeliveryPointsRequest;
use WishboxCdek\Response\DeliveryPoint\DeliveryPointDto;

final class DeliveryPointApiTest extends TestCase
{
    public function test_get_list_hydrates_documented_delivery_point_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '[{"code":"MSK123","uuid":"delivery-point-uuid","address_comment":"Business center","nearest_station":"Belorussky Station","nearest_metro_station":"Belorusskaya","work_time":"Mon-Fri 10:00-20:00","phones":[{"number":"+74950000000","additional":"123"}],"email":"point@example.com","note":"Entrance from yard","type":null,"owner_code":"CDEK","take_only":null,"is_handout":null,"is_reception":null,"is_dressing_room":null,"is_marketplace":null,"is_ltl":null,"have_cashless":null,"have_cash":null,"have_fast_payment_system":null,"allowed_cod":null,"site":"https://cdek.ru","office_image_list":[{"number":null,"url":"https://cdn.example.com/office.jpg"}],"work_time_list":[{"day":null,"time":"10:00/20:00"}],"work_time_exception_list":[{"date_start":"2020-01-01","date_end":"2020-02-02","time_start":"09:00","time_end":"18:00","is_working":false}],"weight_min":null,"weight_max":null,"dimensions":[{"width":null,"height":null,"depth":null}],"errors":[{"code":null,"additional_code":null,"message":null}],"warnings":[{"code":null,"message":null}],"location":{"country_code":"RU","region_code":null,"region":"Moscow","city_code":null,"city":"Moscow","fias_guid":null,"postal_code":"101000","longitude":null,"latitude":null,"address":"Tverskaya 1","address_full":"101000, Russia, Moscow, Tverskaya 1","city_uuid":null},"distance":null,"ltl_acceptance_partners":null,"ltl_issuance_partners":null,"fulfillment":null}]'),
        ]);

        $client = new CdekClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => CdekClient::SANDBOX_BASE_URL,
                'access_token' => 'test-token',
            ]
        );

        $response = $client->deliveryPoints()->getList(new GetDeliveryPointsRequest(cityCode: 44, haveCash: true, size: 10, lang: Language::ENG));

        self::assertCount(1, $response);
        self::assertContainsOnlyInstancesOf(DeliveryPointDto::class, $response);
        self::assertSame('MSK123', $response[0]->code);
        self::assertSame('delivery-point-uuid', $response[0]->uuid);
        self::assertSame('Business center', $response[0]->addressComment);
        self::assertSame('Belorussky Station', $response[0]->nearestStation);
        self::assertSame('Belorusskaya', $response[0]->nearestMetroStation);
        self::assertSame('Mon-Fri 10:00-20:00', $response[0]->workTime);
        self::assertCount(1, $response[0]->phones);
        self::assertSame('+74950000000', $response[0]->phones[0]->number);
        self::assertSame('123', $response[0]->phones[0]->additional);
        self::assertSame('point@example.com', $response[0]->email);
        self::assertSame('Entrance from yard', $response[0]->note);
        self::assertNull($response[0]->type);
        self::assertSame('CDEK', $response[0]->ownerCode);
        self::assertNull($response[0]->takeOnly);
        self::assertNull($response[0]->isHandout);
        self::assertNull($response[0]->isReception);
        self::assertNull($response[0]->isDressingRoom);
        self::assertNull($response[0]->isMarketplace);
        self::assertNull($response[0]->isLtl);
        self::assertNull($response[0]->haveCashless);
        self::assertNull($response[0]->haveCash);
        self::assertNull($response[0]->haveFastPaymentSystem);
        self::assertNull($response[0]->allowedCod);
        self::assertSame('https://cdek.ru', $response[0]->site);
        self::assertCount(1, $response[0]->officeImageList);
        self::assertNull($response[0]->officeImageList[0]->number);
        self::assertSame('https://cdn.example.com/office.jpg', $response[0]->officeImageList[0]->url);
        self::assertCount(1, $response[0]->workTimeList);
        self::assertNull($response[0]->workTimeList[0]->day);
        self::assertSame('10:00/20:00', $response[0]->workTimeList[0]->time);
        self::assertCount(1, $response[0]->workTimeExceptionList);
        self::assertSame('2020-01-01', $response[0]->workTimeExceptionList[0]->dateStart);
        self::assertSame('2020-02-02', $response[0]->workTimeExceptionList[0]->dateEnd);
        self::assertSame('09:00', $response[0]->workTimeExceptionList[0]->timeStart);
        self::assertSame('18:00', $response[0]->workTimeExceptionList[0]->timeEnd);
        self::assertFalse($response[0]->workTimeExceptionList[0]->isWorking ?? true);
        self::assertNull($response[0]->weightMin);
        self::assertNull($response[0]->weightMax);
        self::assertCount(1, $response[0]->dimensions);
        self::assertNull($response[0]->dimensions[0]->width);
        self::assertNull($response[0]->dimensions[0]->height);
        self::assertNull($response[0]->dimensions[0]->depth);
        self::assertCount(1, $response[0]->errors);
        self::assertNull($response[0]->errors[0]->code);
        self::assertNull($response[0]->errors[0]->additionalCode);
        self::assertNull($response[0]->errors[0]->message);
        self::assertCount(1, $response[0]->warnings);
        self::assertNull($response[0]->warnings[0]->code);
        self::assertNull($response[0]->warnings[0]->message);
        self::assertSame('RU', $response[0]->location?->countryCode);
        self::assertNull($response[0]->location?->regionCode);
        self::assertSame('Moscow', $response[0]->location?->region);
        self::assertNull($response[0]->location?->cityCode);
        self::assertSame('Moscow', $response[0]->location?->city);
        self::assertNull($response[0]->location?->fiasGuid);
        self::assertSame('101000', $response[0]->location?->postalCode);
        self::assertNull($response[0]->location?->longitude);
        self::assertNull($response[0]->location?->latitude);
        self::assertSame('Tverskaya 1', $response[0]->location?->address);
        self::assertSame('101000, Russia, Moscow, Tverskaya 1', $response[0]->location?->addressFull);
        self::assertNull($response[0]->location?->cityUuid);
        self::assertNull($response[0]->distance);
        self::assertNull($response[0]->ltlAcceptancePartners);
        self::assertNull($response[0]->ltlIssuancePartners);
        self::assertNull($response[0]->fulfillment);
        self::assertCount(1, $httpClient->requests);
        self::assertSame('GET', $httpClient->requests[0]->getMethod());
        self::assertStringContainsString('/v2/deliverypoints?city_code=44&have_cash=1&size=10&lang=eng', (string) $httpClient->requests[0]->getUri());
    }
}




