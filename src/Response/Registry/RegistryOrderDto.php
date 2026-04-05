<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Registry;

final readonly class RegistryOrderDto
{
    public function __construct(
        public ?string $cdekNumber = null,
        public int|float|null $transferSum = null,
        public int|float|null $paymentSum = null,
        public int|float|null $totalSumWithoutAgent = null,
        public int|float|null $agentCommissionSum = null,
        public ?int $basisType = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            transferSum: isset($data['transfer_sum']) ? $data['transfer_sum'] : null,
            paymentSum: isset($data['payment_sum']) ? $data['payment_sum'] : null,
            totalSumWithoutAgent: isset($data['total_sum_without_agent']) ? $data['total_sum_without_agent'] : null,
            agentCommissionSum: isset($data['agent_commission_sum']) ? $data['agent_commission_sum'] : null,
            basisType: isset($data['basis_type']) ? (int) $data['basis_type'] : null,
        );
    }
}
