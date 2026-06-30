<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class PackageRequestDto extends RequestData
{
	public string $number;
	public int $weight;
	public ?int $length;
	public ?int $width;
	public ?int $height;
	public ?string $comment;

	/**
	 * /**
	 * @var list<ItemRequestDto>
	 *
	 * @since 1.0.0
	 */
	public array $items;

	public ?string $packageId;

	/**
	 * @param   list<ItemRequestDto>  $items
	 *
	 * @since 1.0.0
	 */
	public function __construct(
		string  $number,
		int     $weight,
		?int    $length = null,
		?int    $width = null,
		?int    $height = null,
		?string $comment = null,
		array   $items = [],
		?string $packageId = null,
	)
	{
		$this->number    = $number;
		$this->weight    = $weight;
		$this->length    = $length;
		$this->width     = $width;
		$this->height    = $height;
		$this->comment   = $comment;
		$this->items     = self::validateList($items, ItemRequestDto::class, self::class, 'items');
		$this->packageId = $packageId;
	}

	public function toArray(): array
	{
		return $this->normalizeArray([
			'number'     => $this->number,
			'weight'     => $this->weight,
			'length'     => $this->length,
			'width'      => $this->width,
			'height'     => $this->height,
			'comment'    => $this->comment,
			'items'      => $this->items === [] ? null : $this->items,
			'package_id' => $this->packageId,
		]);
	}
}
