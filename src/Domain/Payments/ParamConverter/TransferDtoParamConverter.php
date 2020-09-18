<?php

namespace App\Domain\Payments\ParamConverter;

use App\Domain\Payments\Dto\TransferDto;
use App\Domain\Payments\Repository\WalletRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TransferDtoParamConverter implements ParamConverterInterface
{

    /** @var WalletRepository */
    private $walletRepository;

    private const FROM_WALLET = 'fromWallet';
    private const TO_WALLET = 'toWallet';
    private const TRANSFER_AMOUNT = 'transferAmount';

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $fromWalletId = $request->get(self::FROM_WALLET);
        $toWalletId = $request->get(self::TO_WALLET);
        $transferAmount = $request->get(self::TRANSFER_AMOUNT);

        if ($fromWalletId === null || $toWalletId === null || $transferAmount === null) {
            throw new NotFoundHttpException();
        }

        $fromWallet = $this->walletRepository->getUserWallet($fromWalletId);

        if ($fromWallet === null) {
            throw new AccessDeniedException();
        }

        $toWallet = $this->walletRepository->getUserWallet($toWalletId);

        if ($toWallet === null) {
            throw new AccessDeniedException();
        }

        $transferDto = new TransferDto(
            $transferAmount,
            $transferAmount,
            $fromWallet,
            $toWallet
        );

        $request->attributes->set($configuration->getName(), $transferDto);
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getName() === $this->getName();
    }

    public function getName()
    {
        return 'transferDto';
    }
}