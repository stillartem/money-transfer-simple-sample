<?php

namespace App\Port\Controller;

use App\Domain\Payments\Dto\TransferDto;
use App\Domain\Payments\Service\BalanceService;
use App\Domain\Payments\Service\TransferService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Domain\Payments\Entity\Wallet;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment-api", name="payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/transfer/{fromWallet}/{toWallet}/{transferAmount}", name="transfer", methods={"POST"})
     * @ParamConverter("transferDto")
     * //  * @Security("transferDto.getSourceWallet().isUserWallet(user)")
     * @SWG\Post(
     *      summary="Transfer money from one wallet to another",
     *      tags={"Payment"},
     *      produces={"application/json"},
     *
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxOGIyMDBlZmY0NzFiN2JlNmEwZTUwOWZjZDIzY2VkNCIsImp0aSI6IjYwNzYxY2RmMzA5ZDg4YmE5YzRiZjdlYTlkZmQxYjA1ZmY5NjU3MzViYTVmZDgzMDc4ODIzMGM1NWNkZGE0ZmViNTI4NWIyMDMwMmEyYWFlIiwiaWF0IjoxNjAwMzc1NTU4LCJuYmYiOjE2MDAzNzU1NTgsImV4cCI6MTYwMTY3MTU1Nywic3ViIjoiY2FybG9zQHRlc3QuY29tIiwic2NvcGVzIjpbInRyYW5zZmVyIl19.mIz3bOwpCdzSfg1pnvKxoTafZWJoHqOovc8g6LS8V5fWJk7XXockY6zx9GNMU-c6qnUUz7Nqj6srWZBAr9AMjwZ5VO-IihHYLU7tzvAc7HYyas_ESS_-SBXa50YUG5rNsoVUH4j3lj79UwiR8U2GQPMefzY0nrBLTqOdy_MXmQfz7yawv1d-PhznrWee56bNiFcxVQZ4mBoJDfKFi3SEYkPDpPHTbcX2We0LzFf_tOpYM45rwr8zET-z3efA63x3jHyUvCWuUZHLrgOkF1AMX73ORlnk1n5r2uTGhvX0cFSGx7dtUZA5XN_6lslkzkaRp72f1ikU1WqXuk_olOQR2Q", description="Authorization" )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Returns nothing"
     * )
     *
     * @param TransferDto $transferDto
     * @param TransferService $transferService
     * @return JsonResponse
     * @throws \Throwable
     */
    public function transfer(
        TransferDto $transferDto,
        TransferService $transferService
    )
    {
        $transferService->transfer($transferDto);
        return new JsonResponse();
    }

    /**
     * @Route("/balance/{wallet}", name="balance", methods={"GET"})
     * @ParamConverter("wallet", class="App\Domain\Payments\Entity\Wallet")
     * @Security("wallet.isUserWallet(user)")
     * @SWG\Get(
     *      summary="Get balance for wallet",
     *      tags={"Payment"},
     *      produces={"application/json"},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxOGIyMDBlZmY0NzFiN2JlNmEwZTUwOWZjZDIzY2VkNCIsImp0aSI6IjYwNzYxY2RmMzA5ZDg4YmE5YzRiZjdlYTlkZmQxYjA1ZmY5NjU3MzViYTVmZDgzMDc4ODIzMGM1NWNkZGE0ZmViNTI4NWIyMDMwMmEyYWFlIiwiaWF0IjoxNjAwMzc1NTU4LCJuYmYiOjE2MDAzNzU1NTgsImV4cCI6MTYwMTY3MTU1Nywic3ViIjoiY2FybG9zQHRlc3QuY29tIiwic2NvcGVzIjpbInRyYW5zZmVyIl19.mIz3bOwpCdzSfg1pnvKxoTafZWJoHqOovc8g6LS8V5fWJk7XXockY6zx9GNMU-c6qnUUz7Nqj6srWZBAr9AMjwZ5VO-IihHYLU7tzvAc7HYyas_ESS_-SBXa50YUG5rNsoVUH4j3lj79UwiR8U2GQPMefzY0nrBLTqOdy_MXmQfz7yawv1d-PhznrWee56bNiFcxVQZ4mBoJDfKFi3SEYkPDpPHTbcX2We0LzFf_tOpYM45rwr8zET-z3efA63x3jHyUvCWuUZHLrgOkF1AMX73ORlnk1n5r2uTGhvX0cFSGx7dtUZA5XN_6lslkzkaRp72f1ikU1WqXuk_olOQR2Q", description="Authorization" )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Returns nothing"
     * )
     *
     * @param Wallet $wallet
     * @param BalanceService $balanceService
     * @return JsonResponse
     */
    public function getBalance(Wallet $wallet, BalanceService $balanceService)
    {

        return $this->json($balanceService->getBalanceForWallet($wallet)->asArray());
    }
}