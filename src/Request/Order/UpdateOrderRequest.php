<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use InvalidArgumentException;
use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\OrderPrint;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\RequestData;

final readonly class UpdateOrderRequest extends RequestData
{
	/**
	 * @var list<PackageRequestDto>
	 */
	public array $packages;

	/**
	 * @var list<AdditionalOrderType>
	 */
	public array $additionalOrderTypes;

	/**
	 * @var list<DeliveryRecipientCostAdvDto>
	 */
	public array $deliveryRecipientCostAdv;

	/**
	 * @var list<AdditionalServiceRequestDto>
	 */
	public array $services;

	/**
	 * @param   list<PackageRequestDto>            $packages
	 * @param   list<AdditionalOrderType>          $additionalOrderTypes
	 * @param   list<DeliveryRecipientCostAdvDto>  $deliveryRecipientCostAdv
	 * @param   list<AdditionalServiceRequestDto>  $services
	 */
	private function __construct(
		public OrderType         $type,
		public int               $tariffCode,
		public ?SenderContactDto $sender,
		public ContactDto        $recipient,
		array                    $packages,
		public ?string           $uuid = null,
		public ?string           $cdekNumber = null,
		array                    $additionalOrderTypes = [],
		public ?string           $number = null,
		public ?string           $accompanyingNumber = null,
		public ?string           $comment = null,
		public ?string           $shipmentPoint = null,
		public ?string           $deliveryPoint = null,
		public ?string           $dateInvoice = null,
		public ?string           $shipperName = null,
		public ?string           $shipperAddress = null,
		public ?MoneyDto         $deliveryRecipientCost = null,
		array                    $deliveryRecipientCostAdv = [],
		public ?SellerDto        $seller = null,
		public ?LocationDto1     $fromLocation = null,
		public ?LocationDto1     $toLocation = null,
		array                    $services = [],
		public ?bool             $isClientReturn = null,
		public ?bool             $hasReverseOrder = null,
		public ?string           $developerKey = null,
		public ?OrderPrint       $print = null,
		public ?string           $widgetToken = null,
	)
	{
		$this->packages                 = self::validateList($packages, PackageRequestDto::class, self::class, 'packages');
		$this->additionalOrderTypes     = self::validateList($additionalOrderTypes, AdditionalOrderType::class, self::class, 'additionalOrderTypes');
		$this->deliveryRecipientCostAdv = self::validateList($deliveryRecipientCostAdv, DeliveryRecipientCostAdvDto::class, self::class, 'deliveryRecipientCostAdv');
		$this->services                 = self::validateList($services, AdditionalServiceRequestDto::class, self::class, 'services');
	}

	/**
	 * @param   list<PackageRequestDto>  $packages
	 */
	public static function make(
		OrderType  $type,
		int        $tariffCode,
		ContactDto $recipient,
		array      $packages,
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

	/**
	 * @param   list<AdditionalOrderType>  $additionalOrderTypes
	 */
	public function withAdditionalOrderTypes(array $additionalOrderTypes): self
	{
		return $this->rebuild(additionalOrderTypes: $additionalOrderTypes);
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

	public function withDateInvoice(string $dateInvoice): self
	{
		return $this->rebuild(dateInvoice: $dateInvoice);
	}

	public function withShipperName(string $shipperName): self
	{
		return $this->rebuild(shipperName: $shipperName);
	}

	public function withShipperAddress(string $shipperAddress): self
	{
		return $this->rebuild(shipperAddress: $shipperAddress);
	}

	public function withDeliveryRecipientCost(MoneyDto $deliveryRecipientCost): self
	{
		return $this->rebuild(deliveryRecipientCost: $deliveryRecipientCost);
	}

	/**
	 * @param   list<DeliveryRecipientCostAdvDto>  $deliveryRecipientCostAdv
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

	public function withIsClientReturn(bool $isClientReturn): self
	{
		return $this->rebuild(isClientReturn: $isClientReturn);
	}

	public function withHasReverseOrder(bool $hasReverseOrder): self
	{
		return $this->rebuild(hasReverseOrder: $hasReverseOrder);
	}

	public function withDeveloperKey(string $developerKey): self
	{
		return $this->rebuild(developerKey: $developerKey);
	}

	public function withPrint(OrderPrint $print): self
	{
		return $this->rebuild(print: $print);
	}

	public function withWidgetToken(string $widgetToken): self
	{
		return $this->rebuild(widgetToken: $widgetToken);
	}

	public function toArray(): array
	{
		$this->assertRequiredFields();

		return $this->normalizeArray([
			'uuid'                        => $this->uuid,
			'type'                        => $this->type->value,
			'cdek_number'                 => $this->cdekNumber,
			'additional_order_types'      => $this->additionalOrderTypes === []
				? null
				: array_map(static fn(AdditionalOrderType $type): int => $type->value, $this->additionalOrderTypes),
			'number'                      => $this->number,
			'accompanying_number'         => $this->accompanyingNumber,
			'tariff_code'                 => $this->tariffCode,
			'comment'                     => $this->comment,
			'shipment_point'              => $this->shipmentPoint,
			'delivery_point'              => $this->deliveryPoint,
			'date_invoice'                => $this->dateInvoice,
			'shipper_name'                => $this->shipperName,
			'shipper_address'             => $this->shipperAddress,
			'delivery_recipient_cost'     => $this->deliveryRecipientCost,
			'delivery_recipient_cost_adv' => $this->deliveryRecipientCostAdv === [] ? null : $this->deliveryRecipientCostAdv,
			'sender'                      => $this->sender,
			'seller'                      => $this->seller,
			'recipient'                   => $this->recipient,
			'from_location'               => $this->fromLocation,
			'to_location'                 => $this->toLocation,
			'services'                    => $this->services === [] ? null : $this->services,
			'packages'                    => $this->packages,
			'is_client_return'            => $this->isClientReturn,
			'has_reverse_order'           => $this->hasReverseOrder,
			'developer_key'               => $this->developerKey,
			'print'                       => $this->print?->value,
			'widget_token'                => $this->widgetToken,
		]);
	}

	private function rebuild(
		?SenderContactDto       $sender = null,
		?string                 $uuid = null,
		?string                 $cdekNumber = null,
		?array                  $additionalOrderTypes = null,
		?string                 $number = null,
		?string                 $accompanyingNumber = null,
		?string                 $comment = null,
		?string                 $shipmentPoint = null,
		?string                 $deliveryPoint = null,
		?string                 $dateInvoice = null,
		?string                 $shipperName = null,
			?string                 $shipperAddress = null,
			?MoneyDto               $deliveryRecipientCost = null,
			?array                  $deliveryRecipientCostAdv = null,
			?SellerDto              $seller = null,
			?LocationDto1           $fromLocation = null,
			?LocationDto1           $toLocation = null,
			?array                  $services = null,
			?bool                   $isClientReturn = null,
			?bool                   $hasReverseOrder = null,
		?string                 $developerKey = null,
		?OrderPrint             $print = null,
		?string                 $widgetToken = null,
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
			additionalOrderTypes: $additionalOrderTypes ?? $this->additionalOrderTypes,
			number: $number ?? $this->number,
			accompanyingNumber: $accompanyingNumber ?? $this->accompanyingNumber,
			comment: $comment ?? $this->comment,
			shipmentPoint: $shipmentPoint ?? $this->shipmentPoint,
			deliveryPoint: $deliveryPoint ?? $this->deliveryPoint,
			dateInvoice: $dateInvoice ?? $this->dateInvoice,
			shipperName: $shipperName ?? $this->shipperName,
			shipperAddress: $shipperAddress ?? $this->shipperAddress,
			deliveryRecipientCost: $deliveryRecipientCost ?? $this->deliveryRecipientCost,
			deliveryRecipientCostAdv: $deliveryRecipientCostAdv ?? $this->deliveryRecipientCostAdv,
			seller: $seller ?? $this->seller,
			fromLocation: $fromLocation ?? $this->fromLocation,
			toLocation: $toLocation ?? $this->toLocation,
			services: $services ?? $this->services,
			isClientReturn: $isClientReturn ?? $this->isClientReturn,
			hasReverseOrder: $hasReverseOrder ?? $this->hasReverseOrder,
			developerKey: $developerKey ?? $this->developerKey,
			print: $print ?? $this->print,
			widgetToken: $widgetToken ?? $this->widgetToken,
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
