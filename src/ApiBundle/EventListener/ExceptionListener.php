<?php
/**
 * Created by PhpStorm.
 * User: anatoly
 * Date: 16.10.16
 * Time: 13:22
 */

namespace ApiBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = $exception->getMessage();

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent(json_encode(array('Success'=>false, 'Message'=>$message)));

        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        // Send the modified response object to the event
        $event->setResponse($response);
    }
}