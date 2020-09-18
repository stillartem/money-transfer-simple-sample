<?php

namespace App\Domain\Core\ValueObject;

class CurrencyCode
{
    /** @var string */
    private $value;

    /**
     * @param string $code
     * @return self
     */
    public static function fromString(string $code)
    {
        $self = new self();
        $self->value = $code;
        return $self;
    }

    public function __toString()
    {
        return $this->value;
    }

    /**
     * @param CurrencyCode $code
     * @return bool
     */
    public function equals(CurrencyCode $code)
    {
        return $this->value === $code->value;
    }

}