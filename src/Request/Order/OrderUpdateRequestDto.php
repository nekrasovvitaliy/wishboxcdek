<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use InvalidArgumentException;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\RequestData;

final readonly class OrderUpdateRequestDto extends RequestData
{
	/**
	 * @var list<PackageRequestDto>
	 */
	public array $packages;

	/**
	 * @var list<DeliveryCostThresholdDto>
	 */
	public array $deliveryRecipientCostAdv;

	/**
	 * @var list<AdditionalServiceRequestDto>
	 */
	public array $services;

	/**
	 * @var list<OrderType>
	 */
	public array $deliveryTypes;

	/**
	 * @param   list<PackageRequestDto>           $packages
	 * @param   list<DeliveryCostThresholdDto>    $deliveryRecipientCostAdv
	 * @param   list<AdditionalServiceRequestDto> $services
	 * @param   list<OrderType>                   $deliveryTypes
	 */
	private function __construct(
		public OrderType         $type,
		public int               $tariffCode,
		public ?SenderContactDto $sender,
		public RecipientContactDto $recipient,
		array                    $packages,
		public ?string           $uuid = null,
		public ?string           $cdekNumber = null,
		public ?string           $number = null,
		public ?string           $accompanyingNumber = null,
		public ?string           $comment = null,
		public ?string           $shipmentPoint = null,
		public ?string           $deliveryPoint = null,
		public ?MoneyDto         $deliveryRecipientCost = null,
		array                    $deliveryRecipientCostAdv = [],
		public ?SellerDto        $seller = null,
		public ?LocationDto1     $fromLocation = null,
		public ?LocationDto1     $toLocation = null,
		array                    $services = [],
		public ?bool             $hasReverseOrder = null,
		array                    $deliveryTypes = [],
	)
	{
		$this->packages                 = self::validateList($packages, PackageRequestDto::class, self::class, 'packages');
		$this->deliveryRecipientCostAdv = self::validateList($deliveryRecipientCostAdv, DeliveryCostThresholdDto::class, self::class, 'deliveryRecipientCostAdv');
		$this->services                 = self::validateList($services, AdditionalServiceRequestDto::class, self::class, 'services');
		$this->deliveryTypes            = self::validateList($deliveryTypes, OrderType::class, self::class, 'deliveryTypes');
	}

	/**
	 * @param   list<PackageRequestDto>  $packages
	 */
	public static function make(
		OrderType           $type,
		int                 $tariffCode,
		RecipientContactDto $recipient,
		array               $packages,
	): self
	{
		return new self(
			type: $type,
			tariffCode: $tariffCode,
			sender: null,
			recipient: $recipient,
			packages: $packages,
		);
	}

	public function withSender(SenderContactDto $sender): self
	{
		return $this->rebuild(sender: $sender);
	}

	public function withUuid(string $uuid): self
	{
		return $this->rebuild(uuid: $uuid);
	}

	public function withCdekNumber(string $cdekNumber): self
	{
		return $this->rebuild(cdekNumber: $cdekNumber);
	}

	public function withNumber(string $number): self
	{
		return $this->rebuild(number: $number);
	}

	public function withAccompanyingNumber(string $accompanyingNumber): self
	{
		return $this->rebuild(accompanyingNumber: $accompanyingNumber);
	}

	public function withComment(string $comment): self
	{
		return $this->rebuild(comment: $comment);
	}

	public function withShipmentPoint(string $shipmentPoint): self
	{
		return $this->rebuild(shipmentPoint: $shipmentPoint);
	}

	public function withDeliveryPoint(string $deliveryPoint): self
	{
		return $this->rebuild(deliveryPoint: $deliveryPoint);
	}

	public function withDeliveryRecipientCost(MoneyDto $deliveryRecipientCost): self
	{
		return $this->rebuild(deliveryRecipientCost: $deliveryRecipientCost);
	}

	/**
	 * @param   list<DeliveryCostThresholdDto>  $deliveryRecipientCostAdv
	 */
	public function withDeliveryRecipientCostAdv(array $deliveryRecipientCostAdv): self
	{
		return $this->rebuild(deliveryRecipientCostAdv: $deliveryRecipientCostAdv);
	}

	public function withSeller(SellerDto $seller): self
	{
		return $this->rebuild(seller: $seller);
	}

	public function withFromLocation(LocationDto1 $fromLocation): self
	{
		return $this->rebuild(fromLocation: $fromLocation);
	}

	public function withToLocation(LocationDto1 $toLocation): self
	{
		return $this->rebuild(toLocation: $toLocation);
	}

	/**
	 * @param   list<AdditionalServiceRequestDto>  $services
	 */
	public function withServices(array $services): self
	{
		return $this->rebuild(services: $services);
	}

	public function withHasReverseOrder(bool $hasReverseOrder): self
	{
		return $this->rebuild(hasReverseOrder: $hasReverseOrder);
	}

	/**
	 * @param   list<OrderType>  $deliveryTypes
	 */
	public function withDeliveryTypes(array $deliveryTypes): self
	{
		return $this->rebuild(deliveryTypes: $deliveryTypes);
	}

	public function toArray(): array
	{
		$this->assertRequiredFields();

		return $this->normalizeArray([
			'uuid'                        => $this->uuid,
			'type'                        => $this->type->value,
			'cdek_number'                 => $this->cdekNumber,
			'number'                      => $this->number,
			'accompanying_number'         => $this->accompanyingNumber,
			'tariff_code'                 => $this->tariffCode,
			'comment'                     => $this->comment,
			'shipment_point'              => $this->shipmentPoint,
			'delivery_point'              => $this->deliveryPoint,
			'delivery_recipient_cost'     => $this->deliveryRecipientCost,
			'delivery_recipient_cost_adv' => $this->deliveryRecipientCostAdv === [] ? null : $this->deliveryRecipientCostAdv,
			'sender'                      => $this->sender,
			'seller'                      => $this->seller,
			'recipient'                   => $this->recipient,
			'from_location'               => $this->fromLocation,
			'to_location'                 => $this->toLocation,
			'services'                    => $this->services === [] ? null : $this->services,
			'packages'                    => $this->packages,
			'has_reverse_order'           => $this->hasReverseOrder,
			'delivery_types'              => $this->deliveryTypes === []
				? null
				: array_map(static fn(OrderType $type): int => $type->value, $this->deliveryTypes),
		]);
	}

	private function rebuild(
		?SenderContactDto       $sender = null,
		?string                 $uuid = null,
		?string                 $cdekNumber = null,
		?string                 $number = null,
		?string                 $accompanyingNumber = null,
		?string                 $comment = null,
		?string                 $shipmentPoint = null,
		?string                 $deliveryPoint = null,
		?MoneyDto               $deliveryRecipientCost = null,
		?array                  $deliveryRecipientCostAdv = null,
		?SellerDto              $seller = null,
		?LocationDto1           $fromLocation = null,
		?LocationDto1           $toLocation = null,
		?array                  $services = null,
		?bool                   $hasReverseOrder = null,
		?array                  $deliveryTypes = null,
	): self
	{
		return new self(
			type: $this->type,
			tariffCode: $this->tariffCode,
			sender: $sender ?? $this->sender,
			recipient: $this->recipient,
			packages: $this->packages,
			uuid: $uuid ?? $this->uuid,
			cdekNumber: $cdekNumber ?? $this->cdekNumber,
			number: $number ?? $this->number,
			accompanyingNumber: $accompanyingNumber ?? $this->accompanyingNumber,
			comment: $comment ?? $this->comment,
			shipmentPoint: $shipmentPoint ?? $this->shipmentPoint,
			deliveryPoint: $deliveryPoint ?? $this->deliveryPoint,
			deliveryRecipientCost: $deliveryRecipientCost ?? $this->deliveryRecipientCost,
			deliveryRecipientCostAdv: $deliveryRecipientCostAdv ?? $this->deliveryRecipientCostAdv,
			seller: $seller ?? $this->seller,
			fromLocation: $fromLocation ?? $this->fromLocation,
			toLocation: $toLocation ?? $this->toLocation,
			services: $services ?? $this->services,
			hasReverseOrder: $hasReverseOrder ?? $this->hasReverseOrder,
			deliveryTypes: $deliveryTypes ?? $this->deliveryTypes,
		);
	}

	private function assertRequiredFields(): void
	{
		if ($this->type === OrderType::DELIVERY && $this->sender === null)
		{
			throw new InvalidArgumentException(sprintf(
				'%s expects sender to be provided for %s orders.',
				self::class,
				OrderType::DELIVERY->name
			));
		}

		$hasUuid = $this->uuid !== null && trim($this->uuid) !== '';
		$hasCdekNumber = $this->cdekNumber !== null && trim($this->cdekNumber) !== '';

		if (!$hasUuid && !$hasCdekNumber) {
			throw new InvalidArgumentException(sprintf(
				'%s expects uuid or cdekNumber to be provided.',
				self::class,
			));
		}
	}
}
