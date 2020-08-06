<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class Produits extends AbstractController
{
    public function index()
    {

        return $this->render('produits.html.twig');
    }
}