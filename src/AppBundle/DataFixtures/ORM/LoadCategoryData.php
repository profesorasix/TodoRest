<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
    	
    	$fd = fopen($data_dir . 'categories.csv', "r");
    	if ($fd) {
    		while (($data = fgetcsv($fd)) !== false) {
    			$category = new Category();
    			$category->setName($data[0]);
    			$manager->persist($category);
    			$this->addReference($data[0],$category);    			    			
    		}    		
    		fclose($fd);
    	}    	
    	$manager->flush();
    }
    
    public function getOrder()
    {
    	// the order in which fixtures will be loaded
    	// the lower the number, the sooner that this fixture is loaded
    	return 1;
    }
    
    /**
     * @override
     */
    public function getEnvironments()
    {
    	return array('prod','dev','test');
    }
}