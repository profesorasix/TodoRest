<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class T42Controller extends Controller
{
    /**
     * @Route("/T42/", name="_welcome")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('T42/T42.html.twig',Array(
        		'page' => 'welcome'));
    }
    
    /**
     * @Route("/T42/about", name="_about")
     */
    public function aboutAction()
    {
        return $this->render('T42/T42.html.twig',Array(
        		'page' => 'about'));       		
    }
    
    /**
     * @Route("/T42/contact", name="_contact")
     */
    public function contactAction()
    {
        return $this->render('T42/T42.html.twig', Array(
        		'page' => 'contact'));
    }
    
    
    
    
}

