<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Prestation;
use App\Form\PrestationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;




class Contact extends AbstractController
{
    public function index()
    {
        

       $em = $this->getDoctrine()->getManager();
       $prestations = [];
       foreach ($em->getRepository('App:Categorie')->findAll() as $categorie) {
           $prestations[$categorie->getName()] = $em->getRepository("App:Prestation")->findBy(['categorie' => $categorie]);
          
       }
       return $this->render('contact.html.twig', [
           'prestations'=>$prestations
       ]);
    }


      /**
     * @Route("/contact/sendmail", name="new_mail")
     */
    public function sendMail(Request $request, \Swift_Mailer $mailer)
{
    $name =  test_input($request->request->get("name")) ;
    $email =   test_input($request->request->get("email"));
    $choix =   $request->request->get("choix");
    $message = (new \Swift_Message('Belles de jour : Demande de prestation'))
        ->setFrom('contact@bellesdejour-institut.com')
        ->setTo('bellesdejour.esthetique@gmail.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/contact.html.twig',
                ['name' => $name, 'email' => $email, "choix"=>$choix]
            ),
            'text/html'
        );

    $mailer->send($message);

    return new JsonResponse("ok",200);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }