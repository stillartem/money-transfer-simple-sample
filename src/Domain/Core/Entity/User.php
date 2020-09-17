<?php

namespace App\Domain\Core\Entity;

use App\Domain\Payments\Entity\Wallet;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
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
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $clientId;


    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $clientSecret;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @var Wallet[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Domain\Payments\Entity\Wallet, mappedBy="user", cascade={"persist"})
     */
    private $wallets;

    public function __construct()
    {
        $this->wallets = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $clientId
     * @return User
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientSecret
     * @return User
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  Wallet $wallet
     * @return User
     */
    public function addWallet(Wallet $wallet)
    {
        if (!$this->wallets->contains($wallet)) {
            $this->wallets->add($wallet);
        }

        return $this;
    }

    /**
     * @param Wallet $wallet
     * @return $this
     */
    public function removeWallet(Wallet $wallet)
    {

        if ($this->wallets->contains($wallet)) {
            $this->wallets->removeElement($wallet);
        }

        return $this;
    }

    /**
     * @return Wallet[]
     */
    public function getWallets()
    {
        return $this->wallets;
    }
}