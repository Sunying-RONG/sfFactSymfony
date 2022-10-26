<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FactController extends AbstractController
{
    // #[Route('/', name: 'app_fact')]
    // public function index(): Response
    // {
    //     return $this->render('factocombi.html.twig');
    // }

    // #[Route('/fact', name: 'app_fact')]
    // public function index(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/FactController.php',
    //     ]);
    // }

    #[Route('/fact/{n<\d+>}')]
    public function fact(Request $request): Response {
        $routeParams = $request->attributes->get('_route_params');
        $fact_result = factorielle($routeParams['n']);
        return new Response($fact_result);
    }

    #[Route('/combi/{n<\d+>}/{p<\d+>}')]
    public function combi(Request $request): Response {
        $routeParams = $request->attributes->get('_route_params');
        return new Response(combinaison($routeParams['n'], $routeParams['p']));
    }

    #[Route('/')]
    public function factoCombi(Request $request): Response {
        if(null !== $request->query->get('p') && null !== $request->query->get('n'))
        {
            $n=intval($request->query->get('n'));
            $p=intval($request->query->get('p'));
            $r=combinaison($n, $p);
            return $this->render('factocombi.html.twig', [
                'n'=>$n,
                'p'=>$p,
                'r'=>$r
            ]);
        } else if (null !== $request->query->get('k')) 
        {
            $k=intval($request->query->get('k'));
            $r=factorielle($k);
            dump($r);
            return $this->render('factocombi.html.twig', [
                'r'=>$r
            ]);
        } else {
            return $this->render('factocombi.html.twig',[]);
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