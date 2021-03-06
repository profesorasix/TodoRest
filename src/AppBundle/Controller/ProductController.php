<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class ProductController extends Controller {
	
	/** 	 
	 * @Route("/{_locale}/product", name="product_index")
	 */
	public function indexAction() {
		return $this->render ( 'product/index.html.twig' );
	}
	
	/**	 
	 * @Route("{_locale}/product/create/", name="product_create_static")
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
	 * @Route("{_locale}/product/create/{name}/{price}", name="product_create",
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
	 * @ApiDoc() 
	 * @Route("{_locale}/product/get/{id}", name="product_show")
	 * @Method("GET")
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
 	 * @ApiDoc() 
	 * @Route("/product/delete/{id}", name="product_delete")
	 *  
	 */
	public function deleteAction($id) {
		$product = $this->getDoctrine ()->getRepository ( 'AppBundle:Product' )->find ( $id );
		
		$em = $this->getDoctrine ()->getManager ();
		
		$em->remove ( $product );
		$em->flush ();
		
		return $this->redirectToRoute ( 'product_list' );
	}	
	
	
	/**
	 * @ApiDoc()
	 * @Route("{_locale}/product/list/category/all.{_format}", name="product_list_category_all",
	 *     defaults={"_format": "html"},
	 *     requirements={
	 * 	        "_format": "html|xml|json",
	 * })
	 * @Method("GET")
	 */
	
	public function listAllByCategoryAction($_format) {
		$categories = $this->getDoctrine()->getRepository('AppBundle:Category' )->findAll();
		
		if ($_format == 'json' || $_format == 'xml') {
			$serialized = $this->get('jms_serializer')->serialize($categories,$_format);		
			return new Response($serialized);
		} else {		
			return $this->render ( 'product/category_list.html.twig', array (
					'categories' => $categories 
			));
		}
	}
	
	/**
	 * @Route("{_locale}/product/list/category/{name}", name="product_list_category")
	 */
	public function listByCategoryAction($name) {
		$categories = $this->getDoctrine ()->getRepository ( 'AppBundle:Category' )->findByName ( $name );
	
		return $this->render ( 'product/category_list.html.twig', array (
				'categories' => $categories
		) );
	}
	
	/**
	 * @ApiDoc() 
	 * @Route("{_locale}/product/list.{_format}", name="product_list",
	 *     defaults={"_format": "html"},
	 *     requirements={	 
	 * 	        "_format": "html|xml|json",
	 * })	
	 * @Method("GET")	 
	 */
	public function listAction($_format) {
		$products = $this->getDoctrine ()->getRepository( 'AppBundle:Product' )
			->findBy(array(),array('id' => 'ASC'));
		
		if ($_format == 'json' || $_format == 'xml') {
			$serialized = $this->get('jms_serializer')->serialize($products,$_format);
			return new Response($serialized);
		} else {
			return $this->render ( 'product/list.html.twig', array (
					'products' => $products
			) );
			
		}
	
		
	}
	
	/**	 
	 * @Route("{_locale}/product/new/", name="product_new")
	 */
	public function newAction(Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		
		$product = new Product();		
				
		$form = $this->createFormBuilder ($product, ['translation_domain' => 'AppBundle'])
		->add ( 'name', 'text', array(
				'label' => 'product.name') )
		->add ( 'description', 'text', array(
				'label' => 'product.description', 
				'required' => false) )
		->add ( 'price', 'money', array(
				'label' => 'product.price',
				'invalid_message' => 'product.flash.price'
		))
		->add ('category', 'entity', array(
				'label' => 'product.category',
				'class' => 'AppBundle:Category',
				'choice_label' => 'name'
		))
		->add ( 'save', 'submit', array (
				'label' => 'product.form.save'))
    		->getForm ();
		
		$form->handleRequest ( $request );
		
		if ($form->isValid ()) {		
			
			$em->persist($product);
			$em->flush();		
			
			
			return $form->get('saveAndAdd')->isClicked()
        		? $this->redirectToRoute('product_new',array(),301)
        		: $this->redirectToRoute('product_list',array(),301);   			
        				
		}
		
		return $this->render ( 'product/new.html.twig', array (
				'form' => $form->createView () 
		) );
	}
	
	/**
	 * @Route("{_locale}/product/edit/{id}", name="product_edit")
	 */
	public function editAction($id, Request $request) {
		
		$em = $this->getDoctrine()->getManager();
	
		$product = $em->getRepository('AppBundle:Product')->find($id);
	
		$form = $this->createFormBuilder ($product,['translation_domain' => 'AppBundle'])
		->add ( 'name', 'text', array(
				'label' => 'product.name') )
		->add ( 'description', 'text', array(
				'label' => 'product.description', 
				'required' => false) )
		->add ( 'price', 'money', array(
				'label' => 'product.price',
				'invalid_message' => 'product.flash.price'
		))
		->add ('category', 'entity', array(
				'label' => 'product.category',
				'class' => 'AppBundle:Category',
				'choice_label' => 'name'
		))
		->add ( 'save', 'submit', array (
				'label' => 'product.form.save'))
    		->getForm ();	
		
	
		$form->handleRequest ( $request );
	
		if ($form->isValid ()) {
				
			$em->persist($product);
			$em->flush();		
			
			return $this->redirectToRoute('product_list',array(),301);
	
		}
	
		return $this->render ( 'product/new.html.twig', array (
				'form' => $form->createView ()
		) );
	}
}
