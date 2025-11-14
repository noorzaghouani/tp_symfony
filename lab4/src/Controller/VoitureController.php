<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;  
use Doctrine\ORM\EntityManagerInterface; 
use App\Form\VoitureForm;
use App\Entity\Voiture;
use App\Repository\VoitureRepository; 

class VoitureController extends AbstractController
{
    #[Route('/voitures', name: 'app_voiture')]
     public function listeVoiture(VoitureRepository $vr): Response
    {   $voitures= $vr -> findAll();
        return $this->render('voiture/listeVoiture.html.twig', [
            'listeVoiture'=> $voitures,
        ]);
    }

    #[Route('/addVoiture', name: 'add_voiture')]
     public function addVoiture(Request $request, EntityManagerInterface $em)
     {
      $voiture = new Voiture();
      $form = $this->createForm(VoitureForm::Class, $voiture);
      $form->handleRequest ($request);
      if ($form->isSubmitted())
        {
          $em->persist($voiture);
          $em->flush();
          return $this->redirectToRoute('app_voiture');
        }
      $this->addFlash('success', 'Voiture ajoutée avec succès !');
      return $this->render('voiture/addVoiture.html.twig', [
          'formV' => $form->createView(),

      ]);
     }

     #[Route('/voiture/{id}', name: 'voitureDelete') ]
     public function delete(EntityManagerInterface $em, VoitureRepository$vr, $id): Response
     {$voiture = $vr->find($id);
     $em->remove($voiture);
     $em->flush();
     $this->addFlash('success', 'Voiture supprimée avec succès !');
     return $this->redirectToRoute('app_voiture');
     }

     #[Route('/updateVoiture/{id}', name: 'voitureUpdate') ]
     public function updateVoiture(Request $request, EntityManagerInterface $em,VoitureRepository$vr, $id): Response
     {$voiture = $vr->find($id);
     $editform = $this->createForm(VoitureForm:: class, $voiture);
     $editform->handleRequest($request);
     if ($editform->isSubmitted() and $editform->isValid()) 
        {
         $em->persist($voiture);
         $em->flush();
         return $this->redirectToRoute( route: 'app_voiture');
        }
     return $this->render('voiture/updateVoiture.html.twig', ['editFormVoiture'=>$editform->createView()]);
    }

}