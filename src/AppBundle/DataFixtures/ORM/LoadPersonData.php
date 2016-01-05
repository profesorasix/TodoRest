<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Person;

class LoadPersonData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
    	
    	$symbonfy_base_dir = $this->container->getParameter('kernel.root_dir');
    	$data_dir = $symbonfy_base_dir . '/Resources/data/';
    	
        $row = 0;
    	$fd = fopen($data_dir . 'person.csv', "r");
    	if ($fd) {
    		while (($data = fgetcsv($fd)) !== false) {
                $row++;
                
                if ($row == 1) continue; //skip header      

    			$person = new Person();
    			$person->setName($data[0]);
                $person->setAge($data[1]);
                $birthDate = \DateTime::createFromFormat('d/m/Y', $data[2]);
                $person->setBirthDate($birthDate);
                $person->setHeight($data[3]);
                $person->setEmail($data[4]);
                $person->setPhone($data[5]);
                $person->setGender($data[6]);
                $person->setDescends($data[7]);
                $person->setVehicle($data[8]);
                $person->setPreferredLanguage($data[9]);
                $person->setEnglishLevel($data[10]);
                $person->setPersonalWebSite($data[11]);
                $person->setCardNumber($data[12]);
                $person->setIBAN($data[13]);

    			$manager->persist($person);
    			    			    			
    		}    		
    		fclose($fd);
    	}    	
    	$manager->flush();
    }
    
    public function getOrder()
    {
    	// the order in which fixtures will be loaded
    	// the lower the number, the sooner that this fixture is loaded
    	return 3;
    }
    
    /**
     * @override
     */
    public function getEnvironments()
    {
    	return array('prod','dev','test');
    }
}