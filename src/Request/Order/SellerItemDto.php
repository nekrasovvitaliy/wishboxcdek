<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use InvalidArgumentException;
use WishboxCdek\Request\RequestData;

final readonly class SellerItemDto extends RequestData
{
	public function __construct(
		/** Наименование продавца. */
		public ?string $name = null,
		/** ИНН продавца. */
		public ?string $inn = null,
		/** Телефон продавца. */
		public ?string $phone = null,
		/** Код формы собственности. */
		public ?string $ownershipForm = null,
		/** Адрес продавца. */
		public ?string $address = null,
		/** Идентификатор подразделения ГИИС ДМДК. */
		public ?string $giisSubdivisionId = null,
	)
	{
		if ($this->address !== null && mb_strlen($this->address) > 255) {
			throw new InvalidArgumentException('SellerItemDto expects address to be at most 255 characters long.');
		}
	}

	public function toArray(): array
	{
		return $this->normalizeArray([
			'name'                => $this->name,
			'inn'                 => $this->inn,
			'phone'               => $this->phone,
			'ownership_form'      => $this->ownershipForm,
			'address'             => $this->address,
			'giis_subdivision_id' => $this->giisSubdivisionId,
		]);
	}
}
