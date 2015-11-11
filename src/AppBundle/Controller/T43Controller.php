<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class T43Controller extends Controller
{
    public function formatAction($year,$_format)
    {       
    	$user1 = array('username' => 'pepe', 'tel' => 232323, 'edad' => 2323, 'd' => 4, 'e' => 5);
    	$user2 = array('username' => 'jsee', 'tel' => 232323, 'edad' => 777, 'd' => 4, 'e' => 5);
    	$users = array($user1,$user2);
    	
    	
    	if ($_format == 'html') {
    		
    		return $this->render('T43/format.html.twig',Array(
    				'users' => $users)
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


