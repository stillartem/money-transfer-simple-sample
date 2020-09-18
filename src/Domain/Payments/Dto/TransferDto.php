<?php

namespace App\Domain\Payments\Dto;

use App\Domain\Core\Dto\Dto;
use App\Domain\Payments\Entity\Wallet;

class TransferDto implements Dto
{
    /** @var float */
    public $amountFromWallet;

    /** @var float */
    public $amountToWallet;

    /** @var Wallet */
    public $fromWallet;

    /** @var Wallet */
    public $toWallet;

    /** @var float */
    public $commission;

    public function __construct(
        float $amountFromWallet,
        float $amountToWallet,
        Wallet $fromWallet,
        Wallet $toWallet
    )
    {
        $this->fromWallet = $fromWallet;
        $this->toWallet = $toWallet;
        $this->amountFromWallet = $amountFromWallet;
        $this->amountToWallet = $amountToWallet;
        $this->commission = 0;
    }

    public function getSourceWallet()
    {
        return $this->fromWallet;
    }
}