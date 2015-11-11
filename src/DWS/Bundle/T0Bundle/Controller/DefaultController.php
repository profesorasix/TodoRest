<?php

namespace DWS\Bundle\T0Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     * @Route("/table/{number}")
     * @Template()
     */
    
    public function tableAction($number)
    {
    	return array('number' => $number, 'numbers' => Array(1,2,3,4,5,6,7));
    }
}
