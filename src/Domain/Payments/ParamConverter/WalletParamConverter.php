<?php

namespace App\Domain\Payments\ParamConverter;

use App\Domain\Payments\Repository\WalletRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class WalletParamConverter implements ParamConverterInterface
{
    /** @var WalletRepository */
    private $walletRepository;

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
        $walletId = $request->get($configuration->getName());

        if ($walletId === null) {
            throw new NotFoundHttpException();
        }

        $wallet = $this->walletRepository->getUserWallet($walletId);
        if ($wallet === null) {
            throw new AccessDeniedException();
        }

        $request->attributes->set($configuration->getName(), $wallet);
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getName() === $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wallet';
    }
}