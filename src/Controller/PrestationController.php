<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Prestation;
use App\Form\PrestationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PrestationController extends AbstractController
{
    /**
     * @Route("/createprestation", name="create_prestation")
     */
    // public function createPrestation()
    // {
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $prestation = new Prestation();
    //     $prestation->setName('Soins du visage');
    //     $prestation->setPrice(10);


    //     // tell Doctrine you want to (eventually) save the Product (no queries yet)
    //     $entityManager->persist($prestation);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return new Response('Saved new prestation with id '.$prestation->getId());
    // }
/**
     * @Route("/getprestation", name="get_prestation")
     */
    public function getPrestation()
    {

        $em = $this->getDoctrine()->getManager();
        $prestations = [];
        foreach ($em->getRepository('App:Categorie')->findAll() as $categorie) {
            $prestations[$categorie->getName()] = $em->getRepository("App:Prestation")->findBy(['categorie' => $categorie]);
           
        }
        return $this->render('prestations.html.twig', [
            'prestations'=>$prestations
        ]);

        // $em = $this->getDoctrine()->getManager();
        // $toutesMesPrestations = $em->getRepository('App:Prestation')->findAll();

        // return $this->render('prestations.html.twig', array(
        //     'prestations' => $toutesMesPrestations 
        //  ));
    }
 /**
     * @Route("/tableau-de-bord/prestations/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prestation = $em->getRepository('App:Prestation')->find($id);

        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($prestation);
            $em->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('prestation/new.html.twig', [
            'form' => $form->createView(),
        ]);


    }
    /**
     * @Route("/tableau-de-bord/newPrestation", name="new_prestation")
     */
    // public function new(Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $prestation = new Prestation();
    //     $form = $this->createForm(PrestationType::class, $prestation);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->persist($prestation);
    //         $em->flush();
    //         return $this->redirectToRoute('liste');
    //     }
    //     return $this->render('prestation/new.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

        /**
     *  @param $id
     * @return RedirectResponse
     * @Route("/tableau-de-bord/newPrestationApi", name="new_prestation_api")
     */
    public function newApi(Request $request)
    {

        if($id = $request->request->get("categorie")){

            $em = $this->getDoctrine()->getManager();
            $prestation = new Prestation();
            $categorie = $em->getRepository('App:Categorie')->find($request->request->get("categorie"));
            $prestation->setName($request->request->get("name"));
            $prestation->setPrice($request->request->get("price"));
            $prestation->setCategorie($categorie);
            $em->persist($prestation);
            $em->flush();
            
            dump($prestation);
           return new JsonResponse($prestation,200);
            
       }
       return new JsonResponse("pas ok",500);
       // return $this->redirectToRoute('liste');
   }

    
     /**
     * @param $id
     * @return RedirectResponse
     * @Route("/tableau-de-bord/getprestations", name="getPrestations")
     */
    public function getPrestations(Request $request) {
        $id = $request->request->get("id");
        
        if($id = $request->request->get("id")){

             $em = $this->getDoctrine()->getManager();
             $prestations = $em->getRepository('App:Prestation')->findByCategorie($id);

             dump($prestations);

            return new JsonResponse($prestations,200);
          
        }
        
        return new JsonResponse("pas ok",500);
        // return $this->redirectToRoute('liste');
    }
       /**
     * @Route("/tableau-de-bord/liste", name="liste")
     */
    // public function list(Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $prestations = [];
    //     foreach ($em->getRepository('App:Categorie')->findAll() as $categorie) {
    //         $prestations[$categorie->getName()] = $em->getRepository("App:Prestation")->findBy(['categorie' => $categorie]);
           
    //     }
    //     return $this->render('prestation/liste.html.twig', [
    //         'prestations'=>$prestations
    //     ]);
    // }

    
   /**
     * @param $id
     * @return RedirectResponse
     * @Route("/tableau-de-bord/liste/delete", name="listeDelete")
     */
    public function delete(Request $request) {
        
        
        if($id = $request->request->get("id")){

             $em = $this->getDoctrine()->getManager();
             $prestation = $em->getRepository('App:Prestation')->find($id);
             $em->remove($prestation);
             $em->flush();
        
            return new JsonResponse("ok",200);
          
        }
        return new JsonResponse("pas ok",500);
        // return $this->redirectToRoute('liste');
    }

 
}
