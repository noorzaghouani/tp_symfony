<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'etudiant')]
    public function index(): Response
    {
        return new Response ("Bonjour mes etudiants");
    }
     
    #[Route ('/etudiant/{id}', name:'affiche_etudiant',  requirements: ['id' => '\d+'])]
    public function affiche_etudiant($id): Response
    {
        return new Response ("Bonjour étudiant numéro: " .$id);
    }

  #[Route('/etudiant/{name}', name: 'etudiant_name', requirements: ['name' => '[a-zA-Z]+'])]
public function etudiantNom(string $name): Response
{
    return $this->render('etudiant/etudiant.html.twig', ['name' => $name]);
}
}

