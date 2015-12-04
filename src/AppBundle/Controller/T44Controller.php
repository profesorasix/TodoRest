<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class T44Controller extends Controller
{	
	public function indexAction()
	{
		return $this->render(sprintf('T44/index.html.twig'));
	}
	
	public function staticAction($page_name)
    {       
    	return $this->render(sprintf('T44/%s.html.twig',$page_name));    	
    }   
}


