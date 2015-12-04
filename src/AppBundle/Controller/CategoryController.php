<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;


class CategoryController extends Controller
{
	/**
	 * @Route("/category/", name="_t52_index")
	 */
	public function indexAction() {
		return $this->render('category/index.html.twig');
	}
	
    /**
     * @Route("/category/create/{name}", name="_t52_category_create")
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
     * @Route("/category/list", name="_t52_category_list")
     */
        
    public function listAction()
    {
    	$categories = $this->getDoctrine()
    	->getRepository('AppBundle:Category')
    	->findAll();    
    	    
    	return $this->render('category/list.html.twig', array('categories' => $categories));
    }
    
    /**
     * @Route("/category/delete/{id}", name="_t52_category_delete")
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
    
    /**
     * @Route("/category/new/", name="_t61_category_new")
     */
    public function newProductAction(Request $request) {
    
    	$em = $this->getDoctrine ()->getManager ();
    
    	$category = new Category();
    
    	$form = $this->createFormBuilder ($category)
    	->add ( 'name', 'text' )    	
    	->add ( 'save', 'submit', array ('label' => 'Save'))
    	->add('saveAndAdd', 'submit', array('label' => 'Save and add'))
    	->getForm ();
    
    	$form->handleRequest ( $request );
    
    	if ($form->isValid ()) {
    			
    		$em->persist($category);
    		$em->flush();
    			
    			
    		return $form->get('saveAndAdd')->isClicked()
    			? $this->redirectToRoute('_t61_category_new',array(),301)
    			: $this->redirectToRoute('_t52_category_list',array(),301);   			
    		
    	}
    
    	return $this->render ('category/new.html.twig', array (
    			'form' => $form->createView ()
    	) );
    }
    
}
