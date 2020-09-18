<?php

namespace App\Domain\Payments\Factory;

use App\Domain\Payments\ChainOfResponsibility\CalcCommissionHandler;
use App\Domain\Payments\ChainOfResponsibility\ExchangeHandler;
use App\Domain\Payments\ChainOfResponsibility\ValidatorHandler;
use App\Domain\Payments\ChainOfResponsibility\ValidatorHandlerInterface;

class CORHandlerFactory
{
    /** @var ValidatorHandler */
    private $validatorHandlerPrototype;

    /** @var ExchangeHandler */
    private $exchangeHandlerPrototype;

    /** @var CalcCommissionHandler */
    private $calcCommissionHandler;

    public function __construct(
        ValidatorHandlerInterface $validatorHandler,
        ExchangeHandler $exchangeHandler,
        CalcCommissionHandler $calcCommissionHandler
    )
    {
        $this->validatorHandlerPrototype = $validatorHandler;
        $this->exchangeHandlerPrototype = $exchangeHandler;
        $this->calcCommissionHandler = $calcCommissionHandler;
    }

    /**
     * @return CalcCommissionHandler
     */
    public function getCommissionCalculator()
    {
        return clone $this->calcCommissionHandler;
    }

    /**
     * @return CalcCommissionHandler|ExchangeHandler
     */
    public function getExchange()
    {
        return clone $this->exchangeHandlerPrototype;
    }

    /**
     * @return ValidatorHandler|ValidatorHandlerInterface
     */
    public function getValidator()
    {
        return clone $this->validatorHandlerPrototype;
    }
}