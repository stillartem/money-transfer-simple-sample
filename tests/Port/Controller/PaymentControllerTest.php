<?php

namespace App\Tests\Port\Controller;

use App\DataFixtures\CustomerFixtures;
use App\Domain\Core\Entity\User;
use App\Domain\Payments\Entity\Transaction;
use App\Domain\Payments\Entity\Wallet;
use App\Domain\Payments\Repository\TransactionRepository;
use App\Domain\Payments\Service\ExchangeService;
use App\Tests\BaseWebTestCase;

/**
 * @group integration
 */
class PaymentControllerTest extends BaseWebTestCase
{
    /** @var User */
    private $carlos;

    /** @var User */
    private $huan;

    /** @var TransactionRepository */
    private $transactionRepository;

    private const TRANSFER_AMOUNT = 50;
    private const COMMISSION = 0.015;

    private const AUTH_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxOGIyMDBlZmY0NzFiN2JlNmEwZTUwOWZjZDIzY2VkNCIsImp0aSI6IjYwNzYxY2RmMzA5ZDg4YmE5YzRiZjdlYTlkZmQxYjA1ZmY5NjU3MzViYTVmZDgzMDc4ODIzMGM1NWNkZGE0ZmViNTI4NWIyMDMwMmEyYWFlIiwiaWF0IjoxNjAwMzc1NTU4LCJuYmYiOjE2MDAzNzU1NTgsImV4cCI6MTYwMTY3MTU1Nywic3ViIjoiY2FybG9zQHRlc3QuY29tIiwic2NvcGVzIjpbInRyYW5zZmVyIl19.mIz3bOwpCdzSfg1pnvKxoTafZWJoHqOovc8g6LS8V5fWJk7XXockY6zx9GNMU-c6qnUUz7Nqj6srWZBAr9AMjwZ5VO-IihHYLU7tzvAc7HYyas_ESS_-SBXa50YUG5rNsoVUH4j3lj79UwiR8U2GQPMefzY0nrBLTqOdy_MXmQfz7yawv1d-PhznrWee56bNiFcxVQZ4mBoJDfKFi3SEYkPDpPHTbcX2We0LzFf_tOpYM45rwr8zET-z3efA63x3jHyUvCWuUZHLrgOkF1AMX73ORlnk1n5r2uTGhvX0cFSGx7dtUZA5XN_6lslkzkaRp72f1ikU1WqXuk_olOQR2Q';

    public function setUp(): void
    {
        parent::setUp();
        $this->carlos = $this->getEntityManager()
            ->getRepository(User::class)
            ->findOneBy(['email' => CustomerFixtures::CARLOS_REFERENCE]);
        $this->huan = $this->getEntityManager()
            ->getRepository(User::class)
            ->findOneBy(['email' => CustomerFixtures::HUAN_REFERENCE]);
        $this->transactionRepository = $this->getEntityManager()
            ->getRepository(Transaction::class);
    }

    public function test_it_should_get_balance_for_carlos_wallet()
    {
        $wallets = $this->carlos->getWallets();
        foreach ($wallets as $wallet) {
            $response = $this->request(
                'GET',
                '/payment-api/balance/' . $wallet->getId(),
                [],
                self::AUTH_TOKEN
            );
            $this->assertEquals($this->transactionRepository->getBalance($wallet), $response['balance']);
            $this->assertEquals($wallet->getId(), $response['wallet-id']);
            $this->assertEquals($this->carlos->getId(), $response['user-id']);
        }
    }

    public function test_it_should_transfer_money_from_carlos_to_huan()
    {
        $wallets = $this->carlos->getWallets();
        /** @var Wallet $huanWallet */
        $huanWallet = $this->huan->getWallets()[0];

        /** @var ExchangeService $exchangeService */
        $exchangeService = self::$container->get(ExchangeService::class);
        foreach ($wallets as $wallet) {
            $initialCarlosBalance = $this->transactionRepository->getBalance($wallet);
            $initialHuanBalance = $this->transactionRepository->getBalance($huanWallet);
            $url = '/payment-api/transfer/'
                . $wallet->getId()
                . '/'
                . $huanWallet->getId()
                . '/' . self::TRANSFER_AMOUNT;
            $response = $this->request(
                'POST',
                $url,
                [],
                self::AUTH_TOKEN
            );
            $this->assertEmpty($response);

            $carlosBalance = $this->transactionRepository->getBalance($wallet);
            $huanBalance = $this->transactionRepository->getBalance($huanWallet);

            $expectedHuanBalance = $initialHuanBalance + $exchangeService->exchange(
                    $wallet->getCurrencyCode(),
                    $huanWallet->getCurrencyCode(),
                    self::TRANSFER_AMOUNT
                );
            $expectedCarlosBalance = $initialCarlosBalance - self::TRANSFER_AMOUNT - (self::TRANSFER_AMOUNT * self::COMMISSION);
            $this->assertSame($expectedCarlosBalance, $carlosBalance, 'carlos');
            $this->assertSame($expectedHuanBalance, $huanBalance, 'huan');
        }
    }
}