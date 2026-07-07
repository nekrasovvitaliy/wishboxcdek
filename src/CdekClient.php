<?php

declare(strict_types=1);

namespace WishboxCdek;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use WishboxCdek\Api\AuthApi;
use WishboxCdek\Api\CalculatorApi;
use WishboxCdek\Api\DeliveryApi;
use WishboxCdek\Api\DeliveryPointApi;
use WishboxCdek\Api\IntakeApi;
use WishboxCdek\Api\InternationalApi;
use WishboxCdek\Api\LocationApi;
use WishboxCdek\Api\OrderApi;
use WishboxCdek\Api\PassportApi;
use WishboxCdek\Api\PrealertApi;
use WishboxCdek\Api\PrintApi;
use WishboxCdek\Api\RegistryApi;
use WishboxCdek\Api\WebhookApi;
use WishboxCdek\Exception\ApiException;
use WishboxCdek\Exception\ApiResponseException;
use WishboxCdek\Exception\CdekException;
use WishboxCdek\Exception\ErrorResponseParser;
use WishboxCdek\Exception\HttpException;
use WishboxCdek\Response\CdekResponse;
use WishboxCdek\Response\RawCdekResponse;

final class CdekClient
{
    public const BASE_URL = 'https://api.cdek.ru';
    public const SANDBOX_BASE_URL = 'https://api.edu.cdek.ru';

    private string $baseUrl;
    private ?string $account;
    private ?string $password;
    private ?string $accessToken;
    private string $userAgent;

    private ?AuthApi $authApi = null;
    private ?LocationApi $locationApi = null;
    private ?DeliveryApi $deliveryApi = null;
    private ?DeliveryPointApi $deliveryPointApi = null;
    private ?PassportApi $passportApi = null;
    private ?CalculatorApi $calculatorApi = null;
    private ?InternationalApi $internationalApi = null;
    private ?OrderApi $orderApi = null;
    private ?IntakeApi $intakeApi = null;
    private ?PrealertApi $prealertApi = null;
    private ?PrintApi $printApi = null;
    private ?RegistryApi $registryApi = null;
    private ?WebhookApi $webhookApi = null;

    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        array $config = []
    ) {
        $this->baseUrl = rtrim((string) ($config['base_url'] ?? self::BASE_URL), '/');
        $this->account = isset($config['account']) ? (string) $config['account'] : null;
        $this->password = isset($config['password']) ? (string) $config['password'] : null;
        $this->accessToken = isset($config['access_token']) ? (string) $config['access_token'] : null;
        $this->userAgent = (string) ($config['user_agent'] ?? 'wishbox-cdek-client/0.1');
    }

    public function auth(): AuthApi
    {
        return $this->authApi ??= new AuthApi($this);
    }

    public function locations(): LocationApi
    {
        return $this->locationApi ??= new LocationApi($this);
    }

    public function delivery(): DeliveryApi
    {
        return $this->deliveryApi ??= new DeliveryApi($this);
    }

    public function deliveryPoints(): DeliveryPointApi
    {
        return $this->deliveryPointApi ??= new DeliveryPointApi($this);
    }

    public function calculator(): CalculatorApi
    {
        return $this->calculatorApi ??= new CalculatorApi($this);
    }

    public function international(): InternationalApi
    {
        return $this->internationalApi ??= new InternationalApi($this);
    }

    public function orders(): OrderApi
    {
        return $this->orderApi ??= new OrderApi($this);
    }

    public function intakes(): IntakeApi
    {
        return $this->intakeApi ??= new IntakeApi($this);
    }

    public function passport(): PassportApi
    {
        return $this->passportApi ??= new PassportApi($this);
    }

    public function prealerts(): PrealertApi
    {
        return $this->prealertApi ??= new PrealertApi($this);
    }

    public function prints(): PrintApi
    {
        return $this->printApi ??= new PrintApi($this);
    }

    public function registries(): RegistryApi
    {
        return $this->registryApi ??= new RegistryApi($this);
    }

    public function webhooks(): WebhookApi
    {
        return $this->webhookApi ??= new WebhookApi($this);
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function request(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
        bool $throwOnBusinessErrors = true
    ): array {
        return $this->requestWithHeaders(
            $method,
            $uri,
            $query,
            $body,
            $headers,
            $authenticated,
            $throwOnBusinessErrors
        )->data;
    }

    public function requestWithHeaders(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
        bool $throwOnBusinessErrors = true
    ): CdekResponse {
        if ($authenticated) {
            $this->ensureAccessToken();
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        if ($body !== null && !isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        return $this->send($method, $uri, $query, $body, $headers, $throwOnBusinessErrors);
    }

    /**
     * @param array<int, callable|string> $responseMap
     */
    public function requestMapped(
        string $method,
        string $uri,
        array $responseMap,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
        bool $throwOnBusinessErrors = true
    ): mixed {
        if ($authenticated) {
            $this->ensureAccessToken();
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        if ($body !== null && !isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        $response = $this->sendJsonResponse(
            $method,
            $uri,
            $query,
            $body,
            $headers,
            throwOnHttpErrors: false,
            throwOnBusinessErrors: $throwOnBusinessErrors
        );

        $mapper = $responseMap[$response->statusCode] ?? null;

        if ($mapper === null) {
            if ($response->statusCode >= 400) {
                $this->throwHttpException($response);
            }

            throw new CdekException(sprintf(
                'Unexpected CDEK response status code %d for %s %s.',
                $response->statusCode,
                strtoupper($method),
                $uri
            ));
        }

        if (is_string($mapper) && method_exists($mapper, 'fromArray')) {
            $mappedResponse = $mapper::fromArray($response->data);
        } elseif (is_callable($mapper)) {
            $mappedResponse = $mapper($response);
        } else {
            throw new CdekException(sprintf(
                'Invalid CDEK response mapper for status code %d.',
                $response->statusCode
            ));
        }

        if ($response->statusCode >= 400) {
            if (!is_object($mappedResponse)) {
                throw new CdekException(sprintf(
                    'CDEK API error mapper for status code %d must return response DTO object.',
                    $response->statusCode
                ));
            }

            $errors = ErrorResponseParser::extractErrors($response->data);
            $message = ErrorResponseParser::extractMessage($response->data, $errors);

            throw new ApiException($message, $response->statusCode, $mappedResponse);
        }

        return $mappedResponse;
    }

    public function requestForm(
        string $method,
        string $uri,
        array $form = [],
        array $query = [],
        array $headers = [],
        bool $authenticated = false
    ): array {
        $headers['Content-Type'] = 'application/x-www-form-urlencoded';

        return $this->request($method, $uri, $query, http_build_query($form), $headers, $authenticated);
    }

    public function requestBinary(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
        string $accept = 'application/pdf'
    ): string {
        return $this->sendBinary($method, $uri, $query, $body, $headers, $authenticated, $accept);
    }

    public function sendRawRequest(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
        string $accept = 'application/json'
    ): RawCdekResponse {
        if ($authenticated) {
            $this->ensureAccessToken();
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        if ($body !== null && !isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        return $this->sendRaw($method, $uri, $query, $body, $headers, $accept);
    }

    private function ensureAccessToken(): void
    {
        if ($this->accessToken !== null && $this->accessToken !== '') {
            return;
        }

        if ($this->account === null || $this->password === null) {
            throw new CdekException('CDEK access token is not set and account credentials are missing.');
        }

        $tokenResponse = $this->auth()->getOAuthToken();
        $token = $tokenResponse->accessToken;

        if ($token === '') {
            throw new CdekException('CDEK OAuth response does not contain access_token.');
        }

        $this->accessToken = $token;
    }

    private function send(
        string $method,
        string $uri,
        array $query,
        array|string|null $body,
        array $headers,
        bool $throwOnBusinessErrors
    ): CdekResponse {
        return $this->sendJsonResponse(
            $method,
            $uri,
            $query,
            $body,
            $headers,
            throwOnHttpErrors: true,
            throwOnBusinessErrors: $throwOnBusinessErrors
        );
    }

    private function sendJsonResponse(
        string $method,
        string $uri,
        array $query,
        array|string|null $body,
        array $headers,
        bool $throwOnHttpErrors,
        bool $throwOnBusinessErrors
    ): CdekResponse {
        $response = $this->sendRaw($method, $uri, $query, $body, $headers, 'application/json');
        $statusCode = $response->statusCode;
        $responseBody = $response->body;

        if ($responseBody === '' || $responseBody === 'null') {
            if ($throwOnHttpErrors && $statusCode >= 400) {
                throw new HttpException('CDEK request failed with empty response body.', $statusCode);
            }

            return new CdekResponse([], $response->headers, $statusCode);
        }

        $decoded = json_decode($responseBody, true);
        if (!is_array($decoded)) {
            throw new CdekException('Unable to decode CDEK response: ' . $responseBody);
        }

        $errors = ErrorResponseParser::extractErrors($decoded);
        $warnings = ErrorResponseParser::extractWarnings($decoded);

        if ($throwOnHttpErrors && $statusCode >= 400) {
            $message = ErrorResponseParser::extractMessage($decoded, $errors);
            throw new HttpException($message, $statusCode, $decoded, $errors, $warnings);
        }

        if ($statusCode < 400 && $throwOnBusinessErrors && ErrorResponseParser::hasBusinessErrors($decoded)) {
            $message = ErrorResponseParser::extractMessage($decoded, $errors);
            $requestStates = ErrorResponseParser::extractRequestStates($decoded);

            throw new ApiResponseException($message, $decoded, $errors, $warnings, $requestStates);
        }

        return new CdekResponse($decoded, $response->headers, $statusCode);
    }

    private function throwHttpException(CdekResponse $response): never
    {
        $errors = ErrorResponseParser::extractErrors($response->data);
        $warnings = ErrorResponseParser::extractWarnings($response->data);
        $message = ErrorResponseParser::extractMessage($response->data, $errors);

        throw new HttpException($message, $response->statusCode, $response->data, $errors, $warnings);
    }

    private function sendBinary(
        string $method,
        string $uri,
        array $query,
        array|string|null $body,
        array $headers,
        bool $authenticated,
        string $accept
    ): string {
        $response = $this->sendRawRequest($method, $uri, $query, $body, $headers, $authenticated, $accept);
        $statusCode = $response->statusCode;
        $responseBody = $response->body;

        if ($statusCode >= 400) {
            $decoded = json_decode($responseBody, true);
            if (is_array($decoded)) {
                $errors = ErrorResponseParser::extractErrors($decoded);
                $warnings = ErrorResponseParser::extractWarnings($decoded);
                $message = ErrorResponseParser::extractMessage($decoded, $errors);

                throw new HttpException($message, $statusCode, $decoded, $errors, $warnings);
            }

            $message = $responseBody !== ''
                ? 'CDEK request failed: ' . $responseBody
                : 'CDEK request failed with empty response body.';

            throw new HttpException($message, $statusCode);
        }

        return $responseBody;
    }

    private function sendRaw(
        string $method,
        string $uri,
        array $query,
        array|string|null $body,
        array $headers,
        string $accept
    ): RawCdekResponse {
        $payload = null;

        if (is_array($body)) {
            $payload = json_encode($body, JSON_THROW_ON_ERROR);
        } elseif (is_string($body)) {
            $payload = $body;
        }

        $request = $this->requestFactory->createRequest(strtoupper($method), $this->buildUrl($uri, $query))
            ->withHeader('Accept', $accept)
            ->withHeader('User-Agent', $this->userAgent);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($payload !== null) {
            $request = $request->withBody($this->streamFactory->createStream($payload));
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            throw new HttpException($exception->getMessage(), 0, [], [], [], $exception);
        }

        return new RawCdekResponse(
            $response->getStatusCode(),
            $response->getHeaders(),
            (string) $response->getBody()
        );
    }

    private function buildUrl(string $uri, array $query): string
    {
        $url = $this->baseUrl . '/' . ltrim($uri, '/');

        if ($query === []) {
            return $url;
        }

        return $url . '?' . http_build_query($query);
    }
}
