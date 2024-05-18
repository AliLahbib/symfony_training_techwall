<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TwigTestingController extends AbstractController
{
    #[Route('/twigTesting', name: 'app_twig_testing')]
    public function sayHello(): Response
    {
        return $this->render('twig_testing/index.html.twig', [
            'prenom' => 'lahbib','nom'=>'ali','pathImg'=>'       '
        ]);
    }
}
