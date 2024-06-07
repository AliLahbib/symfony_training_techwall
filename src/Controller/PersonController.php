<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/personne")]
class PersonController extends AbstractController
{

    #[Route('/alls', name: 'personne.list.alls')]
    public function findAlls(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Person::class);
        $personnes = $repository->findBy([]);

        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }

    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Person::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }


    #[Route('/findByName', name: 'personne.findByName', methods: "post")]
    public function findByName(ManagerRegistry $doctrine, Request $req)
    {
        $name = $req->get('search');

        $repository = $doctrine->getRepository(Person::class);
        $personnes = $repository->findByName($name);
        if ($name == '') {
            $this->addFlash('info', "nom est vide");
        }
        if ($personnes == []) {
            $this->addFlash("info", "aucune personne trouvées ");
            $this->redirectToRoute('personne.list');
        }
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);

    }

    #[Route('/delete/{id<\d+>}', name: 'personne.delete')]
    public function deletePerson(Person $personne = null, ManagerRegistry $doctrine): Response
    {
        if (!$personne) {
            $this->addFlash('error', "La personne n'existe pas ");
            return $this->redirectToRoute('personne.list');
        } else {
            $manager = $doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', "La Personne a été bien supprimée");
        }

        return $this->redirectToRoute('personne.list');
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine, Request $request)
    {
        $personne = new Person();

        $form = $this->createForm(PersonType::class, $personne);
        $form->remove('createdAt');
        $form->remove("updatedAt");
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();
            $this->addFlash("success", $personne->getName() . " a ette ajouté(e) avec succes");
            return $this->redirectToRoute("personne.list");
        }
        return $this->render('personne/add-person.html.twig', ["form" => $form->createView()]);

    }

    #[Route('/edit/{id}', name: 'personne.edit')]
    public function editPersonne( ManagerRegistry $doctrine, Request $request,Person $personne = null): Response
    {
        $new = false;
        if ($personne) {
            $new = true;
        }

        $form = $this->createForm(PersonType::class, $personne);
        $form->remove('createdAt');
        $form->remove("updatedAt");
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();
            if ($new) {
               $message="a été ajouté(e) avec succes";
            } else {
               $message="a été mis(e) à jour avec succes";
            }
            $this->addFlash("success",$personne->getName()." ".$message);
            return $this->redirectToRoute("personne.list");
        }
        return $this->render('personne/add-person.html.twig', ["form" => $form->createView()]);


    }

    #[Route('/stats/{minAge<\d+>}/{maxAge<\d+>}', name: 'personne.stats')]
    public function stats(ManagerRegistry $doctrine, string $minAge, string $maxAge): Response
    {
        $repository = $doctrine->getRepository(Person::class);
        $stats = $repository->statsPersonByAgeIntervale($minAge, $maxAge);
//        dd($stats);
        return $this->render('personne/stats.html.twig', ['stats' => $stats[0], 'ageMin' => $minAge, 'ageMax' => $maxAge]);
    }

    #[Route('/{id}', name: 'personne.detail')]
    public function detail(Person $personne = null): Response
    {
        if (!$personne) {
            $this->addFlash('error', "La personne n'existe pas ");
            return $this->redirectToRoute('personne.list');
        }

        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }

}
