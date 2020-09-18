<?php

namespace App\Domain\Payments\ChainOfResponsibility;

use App\Domain\Payments\Dto\TransferDto;
use App\Domain\Payments\Entity\Rule;

class CalcCommissionHandler extends AbstractHandler implements Handler
{
    /**
     * @param TransferDto $transferDto
     */
    protected function process(TransferDto $transferDto)
    {
        $rule = $transferDto->getSourceWallet()->getRule();
        $transferDto->commission = $transferDto->amountFromWallet * $rule->getCommission();
    }
}