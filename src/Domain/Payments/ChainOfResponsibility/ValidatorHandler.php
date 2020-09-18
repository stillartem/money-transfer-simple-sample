<?php

namespace App\Domain\Payments\ChainOfResponsibility;

use App\Domain\Core\Dto\Dto;
use App\Domain\Payments\Dto\TransferDto;
use App\Domain\Payments\Exception\PaymentException;

class ValidatorHandler extends AbstractHandler implements Handler,ValidatorHandlerInterface
{
    /**
     * @param Dto|TransferDto $transferDto
     * @throws PaymentException
     */
    public function process(TransferDto $transferDto)
    {
       $this->validate($transferDto);
    }

    /**
     * @param Dto|TransferDto $transferDto
     * @throws PaymentException
     */
    public function validate(Dto $transferDto)
    {
        $rule = $transferDto->getSourceWallet()->getRule();
        if ($rule->getMinTransferAmount() > $transferDto->amountFromWallet) {
            throw  PaymentException::minAmount();
        }

        if ($rule->getMaxTransferAmount() < $transferDto->amountToWallet) {
            throw PaymentException::maxAmount();
        }
    }
}