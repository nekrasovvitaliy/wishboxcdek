<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AlertDto
 *
 * Ошибка при обработке запроса контроллером
 */
final readonly class AlertDto
{
    public mixed $type;

    public mixed $msg;

    public mixed $errorCode;

    /**
     * @var array<int|string, mixed> of AlertParamDto
     */
    public array $params;

    public mixed $source;

    public function __construct(
        mixed $type = null,
        mixed $msg = null,
        mixed $errorCode = null,
        array $params = [],
        mixed $source = null,
    ) {
        $this->type = $type;
        $this->msg = $msg;
        $this->errorCode = $errorCode;
        $this->params = $params;
        $this->source = $source;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
            msg: $data['msg'] ?? null,
            errorCode: $data['errorCode'] ?? null,
            params: isset($data['params']) && is_array($data['params']) ? $data['params'] : [],
            source: $data['source'] ?? null,
        );
    }
}
