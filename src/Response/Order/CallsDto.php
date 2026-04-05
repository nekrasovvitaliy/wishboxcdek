<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class CallsDto
{
    /**
     * @param list<FailedCallDto> $failedCalls
     * @param list<RescheduledCallDto> $rescheduledCalls
     */
    public function __construct(
        public array $failedCalls = [],
        public array $rescheduledCalls = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $failedCalls = [];
        if (isset($data['failed_calls']) && is_array($data['failed_calls'])) {
            foreach ($data['failed_calls'] as $item) {
                if (is_array($item)) {
                    $failedCalls[] = FailedCallDto::fromArray($item);
                }
            }
        }

        $rescheduledCalls = [];
        if (isset($data['rescheduled_calls']) && is_array($data['rescheduled_calls'])) {
            foreach ($data['rescheduled_calls'] as $item) {
                if (is_array($item)) {
                    $rescheduledCalls[] = RescheduledCallDto::fromArray($item);
                }
            }
        }

        return new self(
            failedCalls: $failedCalls,
            rescheduledCalls: $rescheduledCalls,
        );
    }
}
