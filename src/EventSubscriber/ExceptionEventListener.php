<?php

namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExceptionEventListener implements EventSubscriberInterface
{

    private $tokenStorageInterface;
    /**
     * @var RouterInterface
     */
    private $routerInterface;

    /**
     * ExceptionEventListener constructor.
     * @param TokenStorageInterface $tokenStorageInterface
     * @param RouterInterface $routerInterface
     */
    public function __construct(TokenStorageInterface $tokenStorageInterface, RouterInterface $routerInterface)
    {
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->routerInterface = $routerInterface;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'getExceptionMessage',
        ];
    }

    public function getExceptionMessage(ExceptionEvent $event): void
    {
        $token = $this->tokenStorageInterface->getToken();

        $exception = $event->getThrowable();

//        if (!$exception instanceof AccessDeniedHttpException) {
//            return;
//        }

        if($exception instanceof AccessDeniedHttpException) {
            if($token->getUser()->getRoles()) {
                $url = '/';
//                $this->response->addFlash('error', 'Vous n\'avez pas accès à cette section');
            } else {
                $url = '/login';
            }
        }

        if($exception instanceof NotFoundHttpException) {
            $url = '/notFound';
        }

//        $response->headers->set('Content-Type', 'application/ld+json');
        $response = new RedirectResponse($url);
        $event->setResponse($response);
//        $this->routerInterface->generate('homepage');
    }
}