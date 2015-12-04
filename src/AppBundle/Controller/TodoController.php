<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\View\View;

/**
 * @RouteResource("todo", pluralize="false")
 */

class TodoController extends FOSRestController
{
	
	/*
	 * ApiDoc()
	 */
	public function cgetAction()
	{
		$todos = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
					
		$view = new View();
		$view->setData($todos);		
		
		return $this->handleView($view);		
	}
	
	
	/*
	 * ApiDoc()
	 */
	public function postAction()
	{
		$todos = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
					
		$view = new View();
		$view->setData($todos);		
		
		return $this->handleView($view);
	}
	
	
	
	
    
}
