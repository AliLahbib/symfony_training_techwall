<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TabController extends AbstractController
{

    #[Route('/tab/users', name: 'tab.users')]
    public function users(): Response
    {
        $users=[
            ["firstname"=>"ali", "name"=>"lahbib","age"=>22],
            ["firstname"=>"khalil", "name"=>"lahbib","age"=>18],
            ["firstname"=>"raja", "name"=>"lahbib","age"=>15],
            ["firstname"=>"sarrouri", "name"=>"Abdessayed ep lahbib","age"=>20],

        ];

        return $this->render('tab/users.html.twig', ["users"=>$users]);
    }

    #[Route('/tab/{nb?5<\d>}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes=[];
        for($i=0;$i<$nb;$i++){
            $notes[]=rand(0,20);

        }
        return $this->render('tab/index.html.twig', [
            'notes' => $notes
        ]);
    }


}
