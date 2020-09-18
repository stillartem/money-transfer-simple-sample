<?php

namespace App\Domain\Payments\ChainOfResponsibility;

use App\Domain\Payments\Dto\TransferDto;

abstract class AbstractHandler implements Handler
{
    /**
     * @var Handler
     */
    protected $next;

    public function setNext(Handler $handler): Handler
    {
        $this->next = $handler;

        return $handler;
    }

    /**
     * @param TransferDto $transferDto
     * @return TransferDto
     */
    public function handle(TransferDto $transferDto): TransferDto
    {
        $this->process($transferDto);
        if ($this->next === null) {
            return $transferDto;
        }
        return $this->next->handle($transferDto);
    }

    abstract protected function process(TransferDto $transferDto);
}