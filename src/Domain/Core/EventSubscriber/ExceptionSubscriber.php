<?php

namespace App\Domain\Core\EventSubscriber;

use App\Domain\Payments\Exception\PaymentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{

    public const INTERNAL_ERROR = 'internal.error';

    public const INVALID_PAYMENT_DATA = 'invalid.payment.data';

    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * return the subscribed events, their methods and priorities
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['logException', 20],
                ['returnFormattedResponse', -10],
            ],
        ];
    }


    /**
     * @param ExceptionEvent $event
     *
     * @throws \Exception
     */
    public function returnFormattedResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = $this->getResponseWithException($exception);

        $event->setResponse($response);
    }


    /**
     * @param ExceptionEvent $event
     */
    public function logException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        switch (true) {
            case $exception instanceof PaymentException:
                return;
            default:
                $this->logger->error(
                    $exception->getMessage(),
                    [
                        'class' => get_class($exception),
                        'trace' => $exception->getMessage(),
                    ]
                );
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return JsonResponse
     */
    public function getResponseWithException(\Throwable $e): JsonResponse
    {
        switch (true) {
            case $e instanceof NotFoundHttpException:
                $code = 'page_not_found';
                $status = Response::HTTP_NOT_FOUND;
                break;
            case $e instanceof \InvalidArgumentException:
            case $e instanceof PaymentException:
                $code = $e->getMessage();
                $status = Response::HTTP_BAD_REQUEST;
                break;
            case $e instanceof AccessDeniedHttpException:
                $code = $e->getMessage();
                $status = Response::HTTP_FORBIDDEN;
                break;
            default:
                $code = $e->getMessage();
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $data = [
            'code' => $code,
            'status' => $status,
            'trace'=>$e->getTraceAsString()
        ];

        return new JsonResponse($data, $status);
    }
}