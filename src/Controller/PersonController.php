<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function findByName(ManagerRegistry $doctrine,Request $req)
    {
        $name=$req->get('search');

        $repository = $doctrine->getRepository(Person::class);
        $personnes = $repository->findByName($name);
        if ($name == '') {
            $this->addFlash('info', "nom est vide");
        }
        if ($personnes==[]) {
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
    public function addPersonne(ManagerRegistry $doctrine)
    {
        $entityManegr = $doctrine->getManager();
        $personne = new Person();

        $personne->setFirstname("raja");
        $personne->setLastname("lahbib");
        $personne->setAge(22);
        $personne2 = new Person();

        $personne2->setFirstname("khalil");
        $personne2->setLastname("lahbib");
        $personne2->setAge(19);
        $entityManegr->persist($personne);
        $entityManegr->persist($personne2);

    $this->addFlash('success','Personnes added successfully');
        $entityManegr->flush();
        return $this->redirectToRoute('personne.list');

    }

    #[Route('/edit/{id}', name: 'personne.edit')]
    public function editPersonne(ManagerRegistry $doctrine, $id, Request $request): Response
    {
        $name = $request->get('name', '');
        $firstname = $request->get('firstname', '');
        $lastname = $request->get('lastname', '');
        $age = $request->get('age', -1);

        $repoistory = $doctrine->getRepository(Person::class);
        $personne = $repoistory->find($id);
        $entityManager = $doctrine->getManager();
        if (!$personne) {
            $this->addFlash('error', "La personne n'existe pas ");
            return $this->redirectToRoute('personne.list');

        } else {

            $personne->setFirstname($firstname);
            $personne->setName($name);
            $personne->setAge($age);
            $personne->setLastname($lastname);
            $entityManager->persist($personne);
            $entityManager->flush();
            print("end edit !!!!");
            $this->addFlash('success', 'la personne a été mis à jour avec success');
            return $this->redirectToRoute('personne.list');

        }
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
