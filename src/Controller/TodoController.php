<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/todo')]
class TodoController extends AbstractController{

    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        //afficher notre tableau de todo
        //si j'ai mon tableau de todo dans ma session je ne fait que l'afficher
        //sinon je l'initialise puis l afficher


        $session=$request->getSession();
        if (!$session->has("todos")){
            $todos=[];
            $session->set("todos",$todos);
            $this->addFlash('info',"La liste vient d'etre initialisé");
        }
        return $this->render('todo/index.html.twig');
    }
    #[Route('/addTodo/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request,$name,$content): RedirectResponse
    {
        $session =$request->getSession();
       //verifier si jai mon tableau todo dans ma session
       if($session->has("todos")){
           //si oui
           //verifier si on a deja un todo avec le meme name
           $todos=$session->get("todos");
           if (isset($todos[$name])){
               //si oui on va afficher un ereur
               $this->addFlash('error',"Le todo d'id $name  existe deja ");
           }
           else{
               //sinon on l'ajoute et on affiche un message de succes
               $todos[$name]=$content;
               $session->set('todos',$todos);
               $this->addFlash('success',"le todo id $name a été ajouter avec succes ");
           }
       }
       else{
           // sinon
           //afficher un erreur et on va rederiger vers le controller index
           $this->addFlash('error',"La liste des todos n'est pas encore initialisé");
       }
       return $this->redirectToRoute('app_todo');
   }

    #[Route('/updateTodo/{name}/{content}',name:'todo.update')]
    public function updateTodo(Request $request,$name,$content): RedirectResponse
    {
        $session =$request->getSession();
        //verifier si jai mon tableau todo dans ma session
        if($session->has("todos")){
            //si oui
            //verifier si on a deja un todo avec le meme name
            $todos=$session->get("todos");
            if (!isset($todos[$name])){
                //si oui on va afficher un ereur
                $this->addFlash('error',"Le todo d'id $name  n'existe pas dans la liste");
            }
            else{
                //sinon on l'ajoute et on affiche un message de succes
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash('success',"le todo id $name a été modifier avec succes ");
            }
        }
        else{
            // sinon
            //afficher un erreur et on va rederiger vers le controller index
            $this->addFlash('error',"La liste des todos n'est pas encore initialisé");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/deleteTodo/{name}',name:'todo.delete')]
    public function deleteTodo(Request $request,$name): RedirectResponse
    {
        $session =$request->getSession();
        //verifier si jai mon tableau todo dans ma session
        if($session->has("todos")){
            //si oui
            //verifier si on a deja un todo avec le meme name
            $todos=$session->get("todos");
            if (!isset($todos[$name])){
                //si oui on va afficher un ereur
                $this->addFlash('error',"Le todo d'id $name  n'existe pas dans la liste");
            }
            else{
                //sinon oui on la supprime et on affiche un message de succes
                unset($todos[$name]);
                $session->set('todos',$todos);
                $this->addFlash('success',"le todo id $name a été supprimer avec succes ");
            }
        }
        else{
            // sinon
            //afficher un erreur et on va rederiger vers le controller index
            $this->addFlash('error',"La liste des todos n'est pas encore initialisé");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/reset',name:'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session =$request->getSession();
        //verifier si jai mon tableau todo dans ma session
        if($session->has("todos")){
            //si oui
            //verifier si on a deja un todo avec le meme name


                $session->remove('todos');
               // $this->addFlash('success',"La list est initialisée avec succes ");
            }
        return $this->redirectToRoute('app_todo');
    }

}

