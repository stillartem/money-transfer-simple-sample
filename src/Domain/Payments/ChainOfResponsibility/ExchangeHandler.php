<?php

namespace App\Domain\Payments\ChainOfResponsibility;

use App\Domain\Payments\Dto\TransferDto;
use App\Domain\Payments\Entity\Wallet;
use App\Domain\Payments\Service\ExchangeService;

class ExchangeHandler extends AbstractHandler implements Handler
{

    /** @var ExchangeService */
    private $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    /**
     * @param TransferDto $transferDto
     */
    protected function process(TransferDto $transferDto)
    {
        $transferDto->amountToWallet = $this->exchangeService->exchange(
            $transferDto->fromWallet->getCurrencyCode(),
            $transferDto->toWallet->getCurrencyCode(),
            $transferDto->amountToWallet
        );
    }
}