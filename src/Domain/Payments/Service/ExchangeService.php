<?php

namespace App\Domain\Payments\Service;

use App\Domain\Core\ValueObject\CurrencyCode;
use App\Domain\Payments\Entity\Wallet;

class ExchangeService
{
    public const HARDCODED_RATE_FOR_BTC_ETH = 10;

    /**
     * @param CurrencyCode $from
     * @param CurrencyCode $to
     * @param float $amount
     * @return float
     */
    public function exchange(CurrencyCode $from, CurrencyCode $to, float $amount)
    {
        if ($from->equals($to)) {
            return $amount;
        }

        if ($from->equals(CurrencyCode::fromString(Wallet::BTC_CODE))) {
            return $amount * 10;
        }

        return $amount / 10;
    }
}