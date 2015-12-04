<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Todo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Todo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="El título no debe ser en blanco")
     */
    private $title;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="done", type="boolean")
     */
    private $done;
    
    /**
     * @var date
     *
     * @ORM\Column(name="created_on", type="date")
     */
    private $CreatedOn;   
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Todo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return Todo
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Todo
     */
    public function setCreatedOn($createdOn)
    {
        $this->CreatedOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->CreatedOn;
    }
}
