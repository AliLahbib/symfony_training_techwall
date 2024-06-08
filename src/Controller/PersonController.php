<?php

namespace App\Controller;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Person;
use App\Entity\Profile;
use App\Form\PersonType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
            dump($personne);
            $manager = $doctrine->getManager();


            $this->removeHobbiesByIsPerson($manager, $personne->getId());
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', "La Personne a été bien supprimée");
        }

        return $this->redirectToRoute('personne.list');
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $personne = new Person();

        $form = $this->createForm(PersonType::class, $personne);
        $form->remove('createdAt');
        $form->remove("updatedAt");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            dump($personne);
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move($this->getParameter('images_Directory'), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $personne->setImage($newFilename);

            }
            //add job to db
            $newJob = new Job();
            $newJob->setDesignation($personne->getJobTitle() ? $personne->getJobTitle() : "");
            $entityManager->persist($newJob);
            $personne->setJob($newJob);
            //add hobbies
            $hobbies = explode(",", $personne->getHobbiesTitle());
            foreach ($hobbies as $hobby) {
                if ($hobby != '') {
                    $newHobby = new Hobby();
                    $newHobby->setDesignation($hobby);
                    $entityManager->persist($newHobby);
                    $personne->addHobby($newHobby);
                }
            }
            $newProfile = new Profile();
            $newProfile->setRs($personne->getRs() ? $personne->getRs() : "");
            $newProfile->setUrl($personne->getUrl() ? $personne->getUrl() : "");
            $personne->setProfile($newProfile);
            $entityManager->persist($newProfile);
            $entityManager->persist($personne);
            $entityManager->flush();
            $this->addFlash("success", $personne->getName() . " a ette ajouté(e) avec succes");
            return $this->redirectToRoute("personne.list");
        }
        return $this->render('personne/add-person.html.twig', ["form" => $form->createView()]);

    }

    #[Route('/edit/{id}', name: 'personne.edit')]
    public function editPersonne(ManagerRegistry $doctrine, Request $request, Person $personne = null, SluggerInterface $slugger): Response
    {
        $new = false;
        if ($personne) {
            $new = true;
        }

        $form = $this->createForm(PersonType::class, $personne);
        $form->remove('createdAt');
        $form->remove("updatedAt");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            dump($personne);
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move($this->getParameter('images_Directory'), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $personne->setImage($newFilename);

            }
            //add job to db
            $newJob = new Job();
            $newJob->setDesignation(($personne->getJobTitle()) ? $personne->getJobTitle() : "");
            $entityManager->persist($newJob);
            $personne->setJob($newJob);
            //add hobbies
            $hobbies = explode(",", $personne->getHobbiesTitle());
            foreach ($hobbies as $hobby) {
                $newHobby = new Hobby();
                $newHobby->setDesignation($hobby);
                $entityManager->persist($newHobby);
                $personne->addHobby($newHobby);
            }
            $newProfile = new Profile();
            $newProfile->setRs($personne->getRs() ? $personne->getRs() : "");
            $newProfile->setUrl($personne->getUrl() ? $personne->getUrl() : "");
            $personne->setProfile($newProfile);
            $entityManager->persist($newProfile);
            $entityManager->persist($personne);
            $entityManager->flush();
            if ($new == true) {
                $message = " a ette ajouté(e) avec succes";
            } else {
                $messgae = " a ette modifié(e) avec succes";
            }
            $this->addFlash("success", $personne->getName() . $message);
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
        dd($personne);
        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }


    public function removeHobbiesByIsPerson(EntityManager $entityManager, $personId)
    {
        $connection = $entityManager->getConnection();
        $query = 'DELETE FROM person_hobby WHERE person_hobby.person_id = :personId';
        $statement = $connection->prepare($query);
        $statement->execute(['personId' => $personId]);
    }


}
