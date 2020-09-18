<?php

namespace App\Domain\Payments\ChainOfResponsibility;

use App\Domain\Payments\Dto\TransferDto;

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(TransferDto $transactionInitiator): ?TransferDto;
}