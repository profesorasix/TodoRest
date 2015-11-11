<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class T43Controller extends Controller
{
	
	public function indexAction() {
		return $this->render('T43/index.html.twig');		
	}
	
	
	public function numberAction($number) {
		return $this->render('T43/number.html.twig',array(
				'number' => $number			
		));		
	}
	
	public function textAction($text) {
		return $this->render('T43/text.html.twig', array(
				'text' => $text
		));	
	}
	
	public function defaultAction($page) {
		return $this->render('T43/default.html.twig', array(
				'page' => $page
		));	
	}
	
	
    public function formatAction($year,$_format)
    {       
    	$data = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);    	    	
    	
    	if ($_format == 'html') {
    		
    		return $this->render('T43/format.html.twig',Array(
    				'data' => $data)
    				);
    		
    	} elseif ($_format = 'json') {
    		   		    		
    		$response = new Response();
    		$response->setContent(json_encode($data));    		
    		$response->headers->set('Content-Type', 'application/json');
    		
    		return $response;
    	}
    	
    	
    }   
       
    /*
     * $response->setContent($this->renderView('T43/format.json.twig',Array(
    		'data' => $data)
    		));
    */    
}


