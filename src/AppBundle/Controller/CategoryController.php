<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;


class CategoryController extends Controller
{
	/**
	 * @Route("{_locale}/category/", name="category_index")
	 */
	public function indexAction() {
		return $this->render('category/index.html.twig');
	}
	
    /**
     * @Route("{_locale}/category/create/{name}", name="category_create")
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
     * @Route("{_locale}/category/list", name="category_list")
     */
        
    public function listAction()
    {
    	$categories = $this->getDoctrine()
    	->getRepository('AppBundle:Category')
    	->findBy(array(),array('id' => 'ASC'));
    	    
    	    
    	return $this->render('category/list.html.twig', array('categories' => $categories));
    }
    
    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    
    public function deleteAction($id)
    {
    	$category = $this->getDoctrine()
    	->getRepository('AppBundle:Category')
    	->find($id);
    	
    	$em = $this->getDoctrine()->getManager();    	 
    	
    	$em->remove($category);
    	$em->flush();
    		
    	return $this->redirectToRoute('category_list');
    }
    
    /**
     * @Route("{_locale}/category/new/", name="category_new")
     */
    public function newProductAction(Request $request) {
    
    	$em = $this->getDoctrine ()->getManager ();
    
    	$category = new Category();
    
    	$form = $this->createFormBuilder ($category,['translation_domain' => 'AppBundle'])
    	->add ( 'name', 'text' )    	
    	->add ( 'save', 'submit', array ('label' => 'Save'))
    	->add('saveAndAdd', 'submit', array('label' => 'Save and add'))
    	->getForm ();
    
    	$form->handleRequest ( $request );
    
    	if ($form->isValid ()) {
    			
    		$em->persist($category);
    		$em->flush();
    			
    			
    		return $form->get('saveAndAdd')->isClicked()
    			? $this->redirectToRoute('category_new',array(),301)
    			: $this->redirectToRoute('category_list',array(),301);   			
    		
    	}
    
    	return $this->render ('category/new.html.twig', array (
    			'form' => $form->createView ()
    	) );
    }
    
    /**
     * @Route("{_locale}/category/edit/{id}", name="category_edit")
     */
    public function editAction($id, Request $request) {
    
    	$em = $this->getDoctrine ()->getManager ();
    	
    	$category = $em->getRepository('AppBundle:Category')->find($id);  
    	
    
    	$form = $this->createFormBuilder ($category,['translation_domain' => 'AppBundle'])
    	->add ( 'name', 'text' )
    	->add ( 'save', 'submit', array ('label' => 'Save'))    	
    	->getForm ();
    
    	$form->handleRequest ( $request );
    
    	if ($form->isValid ()) {
    		 
    		$em->persist($category);
    		$em->flush();    		 
    		 
    		return $this->redirectToRoute('category_list',array(),301);    
    	}
    
    	return $this->render ('category/new.html.twig', array (
    			'form' => $form->createView ()
    	) );
    }
    
}
