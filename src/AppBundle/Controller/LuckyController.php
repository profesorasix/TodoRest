<?php 
// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}

class TablaMultiplicarController extends Controller
{
	/**
	 * @Route("/tabla/{number}")
	 */
	public function tablaAction($number)
	{
				
		return $this->render('AppBundle:Default:tabla.html.twig', array(
				'number' => $number
		));
		
	}
}
