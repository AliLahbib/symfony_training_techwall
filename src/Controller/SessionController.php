<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        //session_start();
        $session=$request->getSession();
        if($session->has("nbVisistes")){
            $nbVisistes=$session->get("nbVisistes")+1;
        }
        else{
            $nbVisistes=1;
        }
        $session->set("nbVisistes",$nbVisistes);


        return $this->render('session/index.html.twig');
    }
}
