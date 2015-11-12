<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;


class CategoryController extends Controller
{
	/**
	 * @Route("/T52/", name="_t52_index")
	 */
	public function indexAction() {
		return $this->render('T52/index.html.twig');
	}
	
    /**
     * @Route("/T52/category/create/{name}", name="_t52_category_create")
     *  requirements={
 	 *     "name": "[A-Za-z0-9\s-]+",
     */
    public function createAction($name)
    {
    	$category = new Category();
    	$category->setName($name);
    	
    	$em = $this->getDoctrine()->getManager();
    
    	$em->persist($category);    	
    	$em->flush();
    	
    	return $this->render('dws/message.html.twig', array(
    			'message' => sprintf("Categoría %s(%d) creado!!",
    					$category->getName(),$category->getId()
    					)
    	));
    
    	    			
    } 
    
    
    /**
     * @Route("/T52/category/list", name="_t52_category_list")
     */
        
    public function listAction()
    {
    	$categories = $this->getDoctrine()
    	->getRepository('AppBundle:Category')
    	->findAll();    
    	    
    	return $this->render('T52/list.html.twig', array('categories' => $categories));
    }
    
    /**
     * @Route("/T52/category/delete/{id}", name="_t52_category_delete")
     */
    
    public function deleteAction($id)
    {
    	$category = $this->getDoctrine()
    	->getRepository('AppBundle:Category')
    	->find($id);
    	
    	$em = $this->getDoctrine()->getManager();    	 
    	
    	$em->remove($category);
    	$em->flush();
    		
    	return $this->redirectToRoute('_t52_category_list');
    }    
    
}
