<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetRequestController extends Controller
{
    public function indexAction(Request $request)
    {
        try {

            $id = $request->query->get('id');
            $route = $request->query->get('route');
            $method = $request->query->get('method');
            $ip = $request->query->get('ip');
            $last_days = (int)$request->query->get('last_days');
            $search = $request->query->get('search');

            $repository = $this->getDoctrine()->getRepository("ApiBundle:Request");

            $query = $repository->createQueryBuilder('r');
            if (!empty($id)) {
                $query->andWhere('r.id = :id')->setParameter('id', $id);
            }
            if (!empty($route)) {
                $query->andWhere('r.route = :route')->setParameter('route', $route);
            }
            if (!empty($method)) {
                $query->andWhere('r.method = :method')->setParameter('method', $method);
            }
            if (!empty($ip)) {
                $query->andWhere('r.ip = :ip')->setParameter('ip', $ip);
            }
            if (!empty($last_days)) {
                $fromtDateTime = new \DateTime;
                $fromtDateTime = $fromtDateTime->sub(new \DateInterval('P' . $last_days . 'D'));
                $query->andWhere('r.created > :fromtDateTime')
                    ->setParameter('fromtDateTime', $fromtDateTime);
            }
            if (!empty($search)) {
                $query->andWhere('r.headers LIKE :search OR r.body LIKE :search')
                    ->setParameter('search', '%' . $search . '%');
            }
            $results = $query->getQuery()->getArrayResult();
        } catch (\Exception $e) {
            $response = new Response(json_encode(array()), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response;
        }

        return new Response(json_encode($results));
    }
}
