<?php

namespace App\Domain\Payments\ChainOfResponsibility;

use App\Domain\Core\Dto\Dto;

interface ValidatorHandlerInterface
{
    public function validate(Dto $dto);
}