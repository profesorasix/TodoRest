<?php

namespace CEED\DWS\T0Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CEEDDWST0Bundle:Default:index.html.twig', array('name' => $name));
    }
}
