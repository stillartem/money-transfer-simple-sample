<?php

namespace App\Domain\Payments\Service;

use App\Domain\Payments\Dto\TransferDto;
use App\Domain\Payments\Entity\Transaction;
use App\Domain\Payments\Entity\TransactionInitiator;
use App\Domain\Payments\Factory\CORHandlerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class TransferService
{
    /** @var CORHandlerFactory */
    private $handlerFactory;
    /** @var ManagerRegistry */
    protected $registry;
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        CORHandlerFactory $handlerFactory,
        EntityManagerInterface $entityManager
    )
    {
        $this->handlerFactory = $handlerFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @param TransferDto $transferDto
     * @throws \Throwable
     */
    public function transfer(TransferDto $transferDto)
    {
        $validator = $this->handlerFactory->getValidator();
        $exchange = $this->handlerFactory->getExchange();
        $commissionCalculator = $this->handlerFactory->getCommissionCalculator();

        $exchange->setNext($commissionCalculator);
        $validator->setNext($exchange);

        $dto = $validator->handle($transferDto);

        $this->startTransferProcess($dto);
    }

    /**
     * @param TransferDto $dto
     * @throws \Throwable
     */
    private function startTransferProcess(TransferDto $dto)
    {
        $transactionInitiator = (new TransactionInitiator())
            ->setStatus(TransactionInitiator::STATUS_NEW)
            ->setType(TransactionInitiator::OPERATION_TYPE_TRANSFER);

        $this->entityManager->beginTransaction();
        try {
            $transactionFrom = (new Transaction())
                ->setAmount($dto->amountFromWallet * -1)
                ->setTransactionInitiator($transactionInitiator)
                ->setType(Transaction::TYPE_TRANSFER)
                ->setWallet($dto->fromWallet);

            $transactionTo = (new Transaction())
                ->setAmount($dto->amountToWallet)
                ->setTransactionInitiator($transactionInitiator)
                ->setType(Transaction::TYPE_TRANSFER)
                ->setWallet($dto->toWallet);

            $commissionTransaction = (new Transaction())
                ->setAmount($dto->commission * -1)
                ->setTransactionInitiator($transactionInitiator)
                ->setType(Transaction::TYPE_COMMISSION)
                ->setWallet($dto->fromWallet);

            $this->entityManager->persist($transactionFrom);
            $this->entityManager->persist($transactionTo);
            $this->entityManager->persist($commissionTransaction);

            $this->entityManager->flush();
            $this->entityManager->commit();


            //SOME OTHER TRANSACTIONS ....
            $transactionInitiator->setStatus(TransactionInitiator::STATUS_DONE);
            $this->entityManager->persist($transactionInitiator);

        } catch (\Throwable $exception) {

            $this->entityManager->rollback();

            $this->entityManager->persist($transactionInitiator);
            $transactionInitiator->setStatus(TransactionInitiator::STATUS_ERROR);

            throw $exception;
        } finally {
            $this->entityManager->flush();
        }
    }
}