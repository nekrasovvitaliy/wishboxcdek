# OpenAPI integration fixes

## POST `/v2/orders`: 400 response schema mismatch

In `openapi_api_v2_integration.json`, `POST /v2/orders` declares:

- `202 Accepted` -> `ResponseDtoRootEntityDto`
- `400 Bad Request` -> `SimplifiedResponseDto1`

In practice, CDEK can return a `400 Bad Request` response with the shape of `ResponseDtoRootEntityDto`, where validation errors are nested inside `requests[*].errors`:

```json
{
  "requests": [
    {
      "type": "CREATE",
      "date_time": "2026-07-06T07:36:06+0000",
      "state": "INVALID",
      "errors": [
        {
          "code": "v2_field_is_empty",
          "message": "[shipment_point] is empty"
        },
        {
          "code": "v2_field_is_empty",
          "message": "[from_location] is empty"
        }
      ]
    }
  ],
  "related_entities": []
}
```

This does not match the documented `SimplifiedResponseDto1` top-level shape:

```json
{
  "errors": [],
  "warnings": []
}
```

When handling `POST /v2/orders` response code `400`, keep support for extracting errors from both:

- `errors` / `warnings` at the top level;
- `requests[*].errors` / `requests[*].warnings` in the async response shape.

The practical response DTO for this actual `400` shape is `WishboxCdek\Response\Order\ResponseDtoRootEntityDto`.
`OrderApi::create` should throw an API-level exception containing this DTO for `400 Bad Request`, and callers should read validation errors from `ResponseDtoRootEntityDto::getErrors()`.

## POST `/v2/webhooks`: request schema uses response DTO with read-only UUID

In `openapi_api_v2_integration.json`, `POST /v2/webhooks` declares request body schema `WebhookDto`.
The same schema is also used for webhook responses and contains:

- `uuid`, marked as `readOnly: true`;
- `type`;
- `url`.

The schema also lists `uuid` in `required`, but clients should not send it when creating a webhook because CDEK generates the webhook UUID.

For request payloads, use a dedicated request DTO:

- `WishboxCdek\Request\Webhook\CreateWebhookRequestDto`

It serializes only:

- `type`;
- `url`.

Keep `WishboxCdek\Dto\OpenApi\WebhookDto` as the response/list DTO.
