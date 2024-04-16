<?php

namespace App\Controller;

use App\Entity\User;

use JetBrains\PhpStorm\NoReturn;
use  Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        //die("je suis la requette /first");
        return $this->forward('App\Controller\FirstController::sayHello2');
    }

    #[Route('/sayHello/{name}/{surname}', name: 'say.hello')]
    public function sayHello(Request $request,$name,$surname): Response
    {      dd($request);
           return $this->render('first/index.html.twig',['name'=>$request->query->get("name"),'surname'=>$request->query->get("surname")]);
    }

    #[Route('/say', name: 'say.hello2')]
    public function sayHello2(): Response
    {
        //die("je suis la requette /first");
        $rand=rand(0,10);

        return $this->render('first/hello.html.twig', [
            'controller_name' => 'Controller First',
            'nameUser'=>new User("khalil"),
        ]);
    }
}
