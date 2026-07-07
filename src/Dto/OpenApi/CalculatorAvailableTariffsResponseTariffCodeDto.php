<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorAvailableTariffsResponseTariffCodeDto
 *
 * Доступный сервис
 */
final readonly class CalculatorAvailableTariffsResponseTariffCodeDto
{
    public mixed $tariffName;

    public mixed $weightMin;

    public mixed $weightMax;

    public mixed $weightCalcMax;

    public mixed $lengthMin;

    public mixed $lengthMax;

    public mixed $widthMin;

    public mixed $widthMax;

    public mixed $heightMin;

    public mixed $heightMax;

    /**
     * @var array<int|string, mixed>
     */
    public array $orderTypes;

    /**
     * @var array<int|string, mixed>
     */
    public array $payerContragentType;

    /**
     * @var array<int|string, mixed>
     */
    public array $senderContragentType;

    /**
     * @var array<int|string, mixed>
     */
    public array $recipientContragentType;

    /**
     * @var array<int|string, mixed> of CalculatorAvailableTariffsResponseDeliveryModeDto
     */
    public array $deliveryModes;

    public mixed $additionalOrderTypesParam;

    public function __construct(
        mixed $tariffName = null,
        mixed $weightMin = null,
        mixed $weightMax = null,
        mixed $weightCalcMax = null,
        mixed $lengthMin = null,
        mixed $lengthMax = null,
        mixed $widthMin = null,
        mixed $widthMax = null,
        mixed $heightMin = null,
        mixed $heightMax = null,
        array $orderTypes = [],
        array $payerContragentType = [],
        array $senderContragentType = [],
        array $recipientContragentType = [],
        array $deliveryModes = [],
        mixed $additionalOrderTypesParam = null,
    ) {
        $this->tariffName = $tariffName;
        $this->weightMin = $weightMin;
        $this->weightMax = $weightMax;
        $this->weightCalcMax = $weightCalcMax;
        $this->lengthMin = $lengthMin;
        $this->lengthMax = $lengthMax;
        $this->widthMin = $widthMin;
        $this->widthMax = $widthMax;
        $this->heightMin = $heightMin;
        $this->heightMax = $heightMax;
        $this->orderTypes = $orderTypes;
        $this->payerContragentType = $payerContragentType;
        $this->senderContragentType = $senderContragentType;
        $this->recipientContragentType = $recipientContragentType;
        $this->deliveryModes = $deliveryModes;
        $this->additionalOrderTypesParam = $additionalOrderTypesParam;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffName: $data['tariff_name'] ?? null,
            weightMin: $data['weight_min'] ?? null,
            weightMax: $data['weight_max'] ?? null,
            weightCalcMax: $data['weight_calc_max'] ?? null,
            lengthMin: $data['length_min'] ?? null,
            lengthMax: $data['length_max'] ?? null,
            widthMin: $data['width_min'] ?? null,
            widthMax: $data['width_max'] ?? null,
            heightMin: $data['height_min'] ?? null,
            heightMax: $data['height_max'] ?? null,
            orderTypes: isset($data['order_types']) && is_array($data['order_types']) ? $data['order_types'] : [],
            payerContragentType: isset($data['payer_contragent_type']) && is_array($data['payer_contragent_type']) ? $data['payer_contragent_type'] : [],
            senderContragentType: isset($data['sender_contragent_type']) && is_array($data['sender_contragent_type']) ? $data['sender_contragent_type'] : [],
            recipientContragentType: isset($data['recipient_contragent_type']) && is_array($data['recipient_contragent_type']) ? $data['recipient_contragent_type'] : [],
            deliveryModes: isset($data['delivery_modes']) && is_array($data['delivery_modes']) ? $data['delivery_modes'] : [],
            additionalOrderTypesParam: $data['additional_order_types_param'] ?? null,
        );
    }
}
