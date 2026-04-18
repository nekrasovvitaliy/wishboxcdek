<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order;

use WishboxCdek\Exception\OrderValidationException;
use WishboxCdek\Request\Order\CreateOrderRequest;
use WishboxCdek\Support\Tariff\TariffModeResolver;
use WishboxCdek\Validation\Order\Rule\CreateOrderValidationRule;
use WishboxCdek\Validation\Order\Rule\DoorTariffAddressRule;
use WishboxCdek\Validation\Order\Rule\PackageItemsNotEmptyRule;
use WishboxCdek\Validation\Order\Rule\PackagesNotEmptyRule;
use WishboxCdek\Validation\Order\Rule\ToLocationRequiredRule;
use WishboxCdek\Validation\Order\Rule\WarehouseTariffDeliveryPointRule;

final readonly class CreateOrderRequestValidator
{
    /**
     * @var list<CreateOrderValidationRule>
     */
    private array $rules;
    private SenderContactDtoValidator $senderValidator;

    /**
     * @param list<CreateOrderValidationRule>|null $rules
     */
    public function __construct(?array $rules = null)
    {
        $tariffModeResolver = new TariffModeResolver();

        $this->senderValidator = new SenderContactDtoValidator();
        $this->rules = $rules ?? [
            new PackagesNotEmptyRule(),
            new PackageItemsNotEmptyRule(),
            new ToLocationRequiredRule(),
            new DoorTariffAddressRule($tariffModeResolver),
            new WarehouseTariffDeliveryPointRule($tariffModeResolver),
        ];
    }

    public function validate(CreateOrderRequest $request): void
    {
        $errors = $this->senderValidator->validate($request->sender);

        foreach ($this->rules as $rule) {
            array_push($errors, ...$rule->validate($request));
        }

        if ($errors !== []) {
            throw new OrderValidationException($errors);
        }
    }
}
