<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FactController extends AbstractController
{
    #[Route('/fact', name: 'app_fact')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FactController.php',
        ]);
    }

    #[Route('/fact/{n<\d+>}')]
    public function fact(Request $request): Response {
        $routeParams = $request->attributes->get('_route_params');
        return new Response(factorielle($routeParams['n']));
    }

    #[Route('/combi/{n<\d+>}/{p<\d+>}')]
    public function combi(Request $request): Response {
        $routeParams = $request->attributes->get('_route_params');
        return new Response(combinaison($routeParams['n'], $routeParams['p']));
    }

    public function factoCombi(Request $request) {
        if(null !== $request->query->get('p') && null !== $request->query->get('n'))
        {
            $n=intval($request->query->get('n'));
            $p=intval($request->query->get('p'));
            $r=factorielle($n)/(factorielle($p)*factorielle($n-$p));
            return $this->render('factoCombi.html.twig', [
                'p'=>$p,
                'n'=>$n,
                'r'=>$r,
            ]);
        } else if (null !== $request->query->get('k')) 
        {
            $k=intval($request->query->get('k'));
            $r=factorielle($k);
        } else {
            return $this->render('base.html.twig', []);
        }
    }
}

function factorielle($n)
{
    $res = 1;
    for ($i = $n; $i > 0; $i--) 
    {
        $res = $res * $i;
    }
    return $res;
}

function combinaison($n, $p)
{
    return factorielle($n)/(factorielle($p)*factorielle($n-$p));
}