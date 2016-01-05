<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\LangageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Person;



class PersonController extends Controller {
	/**
	 * @Route("{_locale}/person", name="_t62_index")
	 */
	public function indexAction() {
		return $this->render ( 'person/index.html.twig' );
	}
	
	
	
	/**			
	 * @Route("{_locale}/person/show/{id}", name="person_show")
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
	 * @Route("{_locale}/person/delete/{id}", name="person_delete")
	 */
	public function deleteAction($id) {
		$person = $this->getDoctrine ()->getRepository ( 'AppBundle:Person' )->find ( $id );
		
		$em = $this->getDoctrine ()->getManager ();
		
		$em->remove ( $person );
		$em->flush ();
		
		return $this->redirectToRoute ( '_person_list' );
	}

	/**
	 * @Route("{_locale}/person/list", name="person_list")
	 */
	public function listAction() {
		$persons = $this->getDoctrine ()->getRepository ( 'AppBundle:Person' )->findAll ();
	
		return $this->render ( 'person/list.html.twig', array (
				'persons' => $persons
		) );
	}
	
	/**
	 * @Route("{_locale}/person/new/", name="person_new")
	 */
	public function newAction(Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		
		$person = new Person();		
				
		$form = $this->createFormBuilder ($person,['translation_domain' => 'AppBundle'])
			->add ( 'name', TextType::class,array(
					'label' => 'person.name',
					'required' => true
			))
			->add ( 'age', TextType::class,array(
					'label'=>'person.age',
					'required' => false
			))
			
			->add('birthDate', BirthdayType::class, array(
					'widget' => 'single_text',
					'format' => 'dd-MM-yyyy',
					'label'=>'person.birth_date',
					'invalid_message' => 'La fecha introducida no es válida (dd/mm/yyyy)',
					'required' => true
			))			
			->add ('height', TextType::class, array(
					'label'=>'person.height',
					'required' => false
			))
			
			->add ('email', EmailType::class, array(
					'label'=>'person.email',
					'required' => true
			))
			->add ('phone', TextType::class,array(
					'label' => 'person.phone',
					'required' => true
			))
			->add('gender', ChoiceType::class, array(
    			'choices'  => array('m' => 'person.form.male', 'f' => 'person.form.female'),
    			'required' => false,
				'label'=>'person.gender',
				'required' => true
			))			
			->add ('descends', IntegerType::class,array(
					'label' => 'person.descends',
					'required' => false
			))
			
			->add('vehicle', CheckboxType::class, array(
					'label'    => 'person.vehicle',
					'required' => false,
			))
			
			
			->add ('preferredLanguage', LanguageType::class,array(
					'label' => 'person.preferred_language',
					'required' => false
			))
			
			->add ('englishLevel', ChoiceType::class, array(
    				'choices'  => array(1 => 'A1', 2 => 'A2', 3 => 'B1', 4 => 'B2', 5 => 'C1', 6 => 'C2'),
					'expanded' => true,
					'multiple' => false,
					'preferred_choices' => Array(2),
					'label' => 'person.english_level',
					'required'=> false
				
			 ))
			 
			 ->add ('personalWebSite', UrlType::class,array(
			 		'label' => 'person.personal_website',
			 		'required' => false
			 ))
			 
			 ->add ('cardNumber', TextType::class,array(
			 		'label' => 'person.card_number',
			 		'required' => false
			 ))
			 
			 ->add ('IBAN', TextType::class,array(
			 		'label' => 'person.iban',
			 		'required' => false
			 ))
			 
			->add ( 'save', SubmitType::class, array ('label' => 'person.form.save'))
			->add ( 'saveAndAdd', SubmitType::class, array ('label' => 'person.form.save_and_add'))  	 		
    		
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

	/**
	 * @Route("{_locale}/person/edit/{id}", name="person_edit")
	 */
	public function editAction($id,Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		    	
    	$person = $em->getRepository('AppBundle:Person')->find($id);  		
				
		$form = $this->createFormBuilder ($person,['translation_domain' => 'AppBundle'])
			->add ( 'name', TextType::class,array(
					'label' => 'person.name',
					'required' => true
			))
			->add ( 'age', TextType::class,array(
					'label'=>'person.age',
					'required' => false
			))
			
			->add('birthDate', BirthdayType::class, array(
					'widget' => 'single_text',
					'format' => 'dd-MM-yyyy',
					'label'=>'person.birth_date',
					'invalid_message' => 'La fecha introducida no es válida (dd/mm/yyyy)',
					'required' => true
			))			
			->add ('height', TextType::class, array(
					'label'=>'person.height',
					'required' => false
			))
			
			->add ('email', EmailType::class, array(
					'label'=>'person.email',
					'required' => true
			))
			->add ('phone', TextType::class,array(
					'label' => 'person.phone',
					'required' => true
			))
			->add('gender', ChoiceType::class, array(
    			'choices'  => array('m' => 'person.form.male', 'f' => 'person.form.female'),
    			'required' => false,
				'label'=>'person.gender',
				'required' => true
			))			
			->add ('descends', IntegerType::class,array(
					'label' => 'person.descends',
					'required' => false
			))
			
			->add('vehicle', CheckboxType::class, array(
					'label'    => 'person.vehicle',
					'required' => false,
			))
			
			
			->add ('preferredLanguage', LanguageType::class,array(
					'label' => 'person.preferred_language',
					'required' => false
			))
			
			->add ('englishLevel', ChoiceType::class, array(
    				'choices'  => array(1 => 'A1', 2 => 'A2', 3 => 'B1', 4 => 'B2', 5 => 'C1', 6 => 'C2'),
					'expanded' => true,
					'multiple' => false,
					'preferred_choices' => Array(2),
					'label' => 'person.english_level',
					'required'=> false
				
			 ))
			 
			 ->add ('personalWebSite', UrlType::class,array(
			 		'label' => 'person.personal_website',
			 		'required' => false
			 ))
			 
			 ->add ('cardNumber', TextType::class,array(
			 		'label' => 'person.card_number',
			 		'required' => false
			 ))
			 
			 ->add ('IBAN', TextType::class,array(
			 		'label' => 'person.iban',
			 		'required' => false
			 ))
			 
			->add ( 'save', SubmitType::class, array ('label' => 'person.form.save'))
    		
    		->getForm ();
		
		$form->handleRequest ( $request );
		
		if ($form->isValid ()) {		
			
			$em->persist($person);
			$em->flush();		
			
			return $this->redirectToRoute('person_list',array(),301);   			
        				
		}
		
		return $this->render ( 'person/new.html.twig', array (
				'form' => $form->createView () 
		) );
	}
}
