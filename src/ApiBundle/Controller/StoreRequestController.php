<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreRequestController extends Controller
{
    public function indexAction(Request $request, $route)
    {
        try {
            $entity = new \ApiBundle\Entity\Request();
            $entity->setHeaders(json_encode($request->headers->all()));
            $entity->setBody($request->getContent());
            $entity->setRoute($route);
            $entity->setMethod($request->getMethod());
            $entity->setIp($request->getClientIp());
            $entity->setCreated(new \DateTime());

            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

        } catch (\Exception $exception) {
            $message = $exception->getMessage();

            $response = new Response();
            $response->setContent(json_encode(array('Success'=>false, 'Message'=>$message)));
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response;
        }

        return new Response(json_encode(array('Success'=>true, 'id'=>$entity->getId())));
    }

}
