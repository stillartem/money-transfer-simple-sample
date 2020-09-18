<?php

namespace App\Domain\Payments\Exception;

class PaymentException extends \Exception
{
    public const MAX_AMOUNT = 'max amount';
    public const MIN_AMOUNT = 'min amount';
    public const SAME_WALLETS = 'same wallets';
    public const RULE_EMPTY = 'rule is empty';

    public static function maxAmount()
    {
        return new self(self::MAX_AMOUNT, 400);
    }

    public static function minAmount()
    {
        return new self(self::MIN_AMOUNT, 400);
    }

    public static function sameWallets()
    {
        return new self(self::SAME_WALLETS, 400);
    }

    public static function ruleIsEmpty()
    {
        return new self(self::RULE_EMPTY, 500);
    }
}