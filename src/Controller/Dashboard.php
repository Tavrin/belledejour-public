<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Prestation;
use App\Form\PrestationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

 /**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */

class Dashboard extends AbstractController
{

    public function index()
    {

      $em = $this->getDoctrine()->getManager();
      $prestations = [];
        foreach ($em->getRepository('App:Categorie')->findAll() as $categorie) {
          $prestations[$categorie->getName()] = $em->getRepository("App:Prestation")->findBy(['categorie' => $categorie]);
         dump($prestations);
      }
      return $this->render('dashboard.html.twig', [
          'prestations'=>$prestations
      ]);
      //  return $this->render('dashboard.html.twig');
    }
  }