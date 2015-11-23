<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class ProductController extends Controller {
	/**
	 * @Route("/product", name="_t51_index")
	 */
	public function indexAction() {
		return $this->render ( 'product/index.html.twig' );
	}
	
	/**
	 * @Route("/product/create/", name="_t51_product_create_static")
	 */
	public function createStaticAction() {
		$em = $this->getDoctrine ()->getManager ();
		
		$categories = $this->getDoctrine ()->getRepository ( 'AppBundle:Category' )->findAll ();
		
		if (! $categories) {
			$category = new Category ();
			$category->setName ( 'Default Category' );
			$em->persist ( $category );
		} else {
			$category = $categories [rand ( 0, count ( $categories ) - 1 )];
		}
		
		$product = new Product ();
		$product->setName ( 'A Foo Bar' );
		$product->setPrice ( '19.99' );
		$product->setDescription ( 'Lorem ipsum dolor' );
		// relacionamos con categoría
		$product->setCategory ( $category );
		
		$em->persist ( $product );
		$em->flush ();
		
		return $this->render ( 'dws/message.html.twig', array (
				'message' => sprintf ( "Producto %s(%d) creado!!", $product->getName (), $product->getId () ) 
		) );
	}
	
	/**
	 * @Route("/product/create/{name}/{price}", name="_t51_product_create",
	 * requirements={
	 * "name": "[A-Za-z0-9\s-]+",
	 * "price" : "\d{2}(\.\d{2})?"
	 * })
	 */
	public function createParamAction($name, $price) {
		$em = $this->getDoctrine ()->getManager ();
		
		$categories = $this->getDoctrine ()->getRepository ( 'AppBundle:Category' )->findAll ();
		
		if (! $categories) {
			$category = new Category ();
			$category->setName ( 'Default Category' );
			$em->persist ( $category );
		} else {
			$category = $categories [rand ( 0, count ( $categories ) - 1 )];
		}
		
		$product = new Product ();
		$product->setName ( $name );
		$product->setPrice ( $price );
		$product->setDescription ( sprintf ( 'Description de %s', $name ) );
		// relacionamos con categoría
		$product->setCategory ( $category );
		
		$em->persist ( $product );
		
		$em->flush ();
		
		return $this->render ( 'dws/message.html.twig', array (
				'message' => sprintf ( "Producto %s(%d) creado!!", $product->getName (), $product->getId () ) 
		) );
	}
	
	/**
	 * @Route("/product/show/{id}", name="_t51_product_show")
	 */
	public function showAction($id) {
		$product = $this->getDoctrine ()->getRepository ( 'AppBundle:Product' )->find ( $id );
		
		if (! $product) {
			return $this->render ( 'dws/message.html.twig', array (
					'message' => sprintf ( "Producto id: %d, no encontrado", $id ) 
			) );
		}
		
		return $this->render ( 'product/show.html.twig', array (
				'product' => $product 
		) );
	}
	
		
	/**
	 * @Route("/product/delete/{id}", name="_t51_product_delete")
	 */
	public function deleteAction($id) {
		$product = $this->getDoctrine ()->getRepository ( 'AppBundle:Product' )->find ( $id );
		
		$em = $this->getDoctrine ()->getManager ();
		
		$em->remove ( $product );
		$em->flush ();
		
		return $this->redirectToRoute ( '_t51_product_list' );
	}
	
	/**
	 * @Route("/product/list/category/{name}", name="_t52_product_list_category")
	 */
	public function listByCategoryAction($name) {
		$categories = $this->getDoctrine ()->getRepository ( 'AppBundle:Category' )->findByName ( $name );
		
		return $this->render ( 'product/category_list.html.twig', array (
				'categories' => $categories 
		) );
	}
	
	
	/**
	 * @Route("/product/list/category/", name="_t52_product_list_category_all")
	 */
	public function listAllByCategoryAction() {
		$categories = $this->getDoctrine ()->getRepository ( 'AppBundle:Category' )->findAll ();
		
		return $this->render ( 'product/category_list.html.twig', array (
				'categories' => $categories 
		) );
	}
	
	/**
	 * @Route("/product/list", name="_t51_product_list")
	 */
	public function listAction() {
		$products = $this->getDoctrine ()->getRepository ( 'AppBundle:Product' )->findAll ();
	
		return $this->render ( 'product/list.html.twig', array (
				'products' => $products
		) );
	}
	
	/**
	 * @Route("/product/new/", name="_t61_product_new")
	 */
	public function newProductAction(Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		
		$product = new Product();		
				
		$form = $this->createFormBuilder ($product)
			->add ( 'name', 'text' )
			->add ( 'description', 'text', array('required' => false) )
			->add ( 'price', 'money', array(			
				'invalid_message' => 'Formato de moneda incorrecto'
				))
			->add ('category', 'entity', array(
					'class' => 'AppBundle:Category',
					'choice_label' => 'name'
			 		))			
			->add ( 'save', 'submit', array ('label' => 'Save'))
    		->add('saveAndAdd', 'submit', array('label' => 'Save and add'))
    		->getForm ();
		
		$form->handleRequest ( $request );
		
		if ($form->isValid ()) {		
			
			$em->persist($product);
			$em->flush();		
			
			
			return $form->get('saveAndAdd')->isClicked()
        		? $this->redirectToRoute('_t61_product_new',array(),301)
        		: $this->redirectToRoute('_t51_product_list',array(),301);   			
        				
		}
		
		return $this->render ( 'product/new.html.twig', array (
				'form' => $form->createView () 
		) );
	}
}
