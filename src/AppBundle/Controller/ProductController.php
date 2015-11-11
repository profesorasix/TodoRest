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
	 * @Route("/T51/", name="_t51_index")
	 */
	public function indexAction() {
		return $this->render('T51/index.html.twig');
	}
	
    /**
     * @Route("/T51/product/create/", name="_t51_product_create_static")
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
    
    	return $this->render('T51/created.html.twig', array('product' => $product));    			
    }
    
    /**
     * @Route("/T51/product/create/{name}/{price}", name="_t51_product_create",
     *  requirements={
 	 *     "name": "[A-Za-z\s]+",
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
    
    	return $this->render('T51/created.html.twig', array('product' => $product));    			
    }
    
    /**
     * @Route("/T51/product/show/{id}", name="_t51_product_show")
     */
    
    public function showAction($id)
    {
    	$product = $this->getDoctrine()
    	->getRepository('AppBundle:Product')
    	->find($id);
    
    	if (!$product) {
    		return $this->render('T51/notFound.html.twig', array('id' => $id));   		
    	}
    
    	return $this->render('T51/show.html.twig', array('product' => $product));    			
    }
    
    /**
     * @Route("/T51/product/list/", name="_t51_product_list")
     */
    
    public function listAction()
    {
    	$products = $this->getDoctrine()
    	->getRepository('AppBundle:Product')
    	->findAll();    
    	    
    	return $this->render('T51/list.html.twig', array('products' => $products));
    }
    
    
}
