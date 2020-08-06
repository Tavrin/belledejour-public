<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class Landing extends AbstractController
{
    public function index()
    {
        
       return $this->render('index.html.twig');
    }
}