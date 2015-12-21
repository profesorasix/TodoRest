<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Person;


class PersonController extends Controller {
	/**
	 * @Route("/person", name="_t62_index")
	 */
	public function indexAction() {
		return $this->render ( 'person/index.html.twig' );
	}
	
	
	
	/**			
	 * @Route("/person/show/{id}", name="person_show")
	 */
	public function showAction($id) {
		$person = $this->getDoctrine ()->getRepository ( 'AppBundle:Person' )->find ( $id );
		
		if (! $person) {
			return $this->render ( 'dws/message.html.twig', array (
					'message' => sprintf ( "Persona id: %d, no encontrado", $id ) 
			) );
		}
		
		return $this->render ( 'person/show.html.twig', array (
				'person' => $person 
		) );
	}	
		
	/**
	 * @Route("/person/delete/{id}", name="person_delete")
	 */
	public function deleteAction($id) {
		$person = $this->getDoctrine ()->getRepository ( 'AppBundle:Person' )->find ( $id );
		
		$em = $this->getDoctrine ()->getManager ();
		
		$em->remove ( $person );
		$em->flush ();
		
		return $this->redirectToRoute ( '_t62_person_list' );
	}

	/**
	 * @Route("/person/list", name="person_list")
	 */
	public function listAction() {
		$persons = $this->getDoctrine ()->getRepository ( 'AppBundle:Person' )->findAll ();
	
		return $this->render ( 'person/list.html.twig', array (
				'persons' => $persons
		) );
	}
	
	/**
	 * @Route("/person/new/", name="person_new")
	 */
	public function newProductAction(Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		
		$person = new Person();		
				
		$form = $this->createFormBuilder ($person)
			->add ( 'name', 'text',array(
					'label' => 'Nombre',
					'required' => true
			))
			->add ( 'age', 'text',array(
					'label'=>'Edad',
					'required' => false
			))
			
			->add('birthDate', 'birthday', array(
					'widget' => 'single_text',
					'format' => 'dd-MM-yyyy',
					'label'=>'Fecha de nac.',
					'invalid_message' => 'La fecha introducida no es válida (dd/mm/yyyy)',
					'required' => true
			))			
			->add ('height', 'text', array(
					'label'=>'Altura(cm)',
					'required' => false
			))
			
			->add ('email', 'email', array(
					'label'=>'email',
					'required' => true
			))
			->add ('phone', 'text',array(
					'label' => 'Tel.',
					'required' => true
			))
			->add('gender', 'choice', array(
    			'choices'  => array('m' => 'Masculino', 'f' => 'Femenino'),
    			'required' => false,
				'label'=>'Genero',
				'required' => true
			))			
			->add ('descends', 'integer',array(
					'label' => 'Descendientes.',
					'required' => false
			))
			
			->add('vehicle', 'checkbox', array(
					'label'    => '¿Vehiculo propio?',
					'required' => false,
			))
			
			
			->add ('preferredLanguage', 'language',array(
					'label' => 'Lenguaje',
					'required' => false
			))
			
			->add ('englishLevel', 'choice', array(
    				'choices'  => array(1 => 'A1', 2 => 'A2', 3 => 'B1', 4 => 'B2', 5 => 'C1', 6 => 'C2'),
					'expanded' => true,
					'multiple' => false,
					'preferred_choices' => Array(2),
					'label' => 'Nivel de inglés',
					'required'=> false
				
			 ))
			 
			 ->add ('personalWebSite', 'url',array(
			 		'label' => 'Web personal(url)',
			 		'required' => false
			 ))
			 
			 ->add ('cardNumber', 'text',array(
			 		'label' => 'Numero de tarjeta de credito/debito',
			 		'required' => false
			 ))
			 
			 ->add ('IBAN', 'text',array(
			 		'label' => 'IBAN',
			 		'required' => false
			 ))
			 
			->add ( 'save', 'submit', array ('label' => 'Save'))
    		->add('saveAndAdd', 'submit', array('label' => 'Save and add'))    		
    		
    		->getForm ();
		
		$form->handleRequest ( $request );
		
		if ($form->isValid ()) {		
			
			$em->persist($person);
			$em->flush();		
			
			
			return $form->get('saveAndAdd')->isClicked()
        		? $this->redirectToRoute('person_new',array(),301)
        		: $this->redirectToRoute('person_list',array(),301);   			
        				
		}
		
		return $this->render ( 'person/new.html.twig', array (
				'form' => $form->createView () 
		) );
	}
}
