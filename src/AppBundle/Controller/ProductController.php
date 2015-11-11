<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;


class ProductController extends Controller
{
    /**
     * @Route("/create/product/", name="create_static_product")
     */
    public function createStaticAction()
    {
    	$category = new Category();
    	$category->setName(sprintf("Category%d",rand(0,10)));
    	
    	$product = new Product();
    	$product->setName('A Foo Bar');
    	$product->setPrice('19.99');
    	$product->setDescription('Lorem ipsum dolor');
    	//relacionamos con categoría
    	$product->setCategory($category);
    
    	$em = $this->getDoctrine()->getManager();
    
    	$em->persist($category);
    	$em->persist($product);
    	$em->flush();
    
    	return $this->render('product/created.html.twig', array('product' => $product));    			
    }
    
    /**
     * @Route("/create/product/{name}/{price}", name="create_product", requirements={
 	 *     "name": "[A-Za-z]+",
 	 *     "price" : "\d{2}(\.\d{2})?"
     * })
     */
    public function createParamAction($name,$price)
    {
    	$category = new Category();
    	$category->setName(sprintf("Category%d",rand(0,10)));
    	
    	$product = new Product();
    	$product->setName($name);
    	$product->setPrice($price);
    	$product->setDescription(sprintf('Description de %s',$name));
    	//relacionamos con categoría
    	$product->setCategory($category);
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$em->persist($category);
    	$em->persist($product);
    
    	$em->flush();
    
    	return $this->render('product/created.html.twig', array('product' => $product));    			
    }
    
    /**
     * @Route("/show/product/{id}", name="show_product")
     */
    
    public function showAction($id)
    {
    	$product = $this->getDoctrine()
    	->getRepository('AppBundle:Product')
    	->find($id);
    
    	if (!$product) {
    		throw $this->createNotFoundException(
    				'No product found for id '.$id
    				);
    	}
    
    	return $this->render('product/show.html.twig', array('product' => $product));    			
    }
    
    /**
     * @Route("/list/product/", name="list_product")
     */
    
    public function listAction()
    {
    	$products = $this->getDoctrine()
    	->getRepository('AppBundle:Product')
    	->findAll();
    
    	if (!$products) {
    		throw $this->createNotFoundException(
    				'No products found'
    				);
    	}
    
    	return $this->render('product/list.html.twig', array('products' => $products));
    }
    
    
}
