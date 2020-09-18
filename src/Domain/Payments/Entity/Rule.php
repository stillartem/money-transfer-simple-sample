<?php

namespace App\Domain\Payments\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rule")
 */
class Rule
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $commission;

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $minTransferAmount;

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $maxTransferAmount;

    /**
     * @param string $commission
     * @return Rule
     */
    public function setCommission(string $commission): Rule
    {
        $this->commission = $commission;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommission(): string
    {
        return $this->commission;
    }

    /**
     * @param string $minTransferAmount
     * @return Rule
     */
    public function setMinTransferAmount(string $minTransferAmount): Rule
    {
        $this->minTransferAmount = $minTransferAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getMinTransferAmount(): string
    {
        return $this->minTransferAmount;
    }

    /**
     * @param string $maxTransferAmount
     * @return Rule
     */
    public function setMaxTransferAmount(string $maxTransferAmount): Rule
    {
        $this->maxTransferAmount = $maxTransferAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getMaxTransferAmount(): string
    {
        return $this->maxTransferAmount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}