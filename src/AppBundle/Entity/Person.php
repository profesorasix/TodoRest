<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)     
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")     
     * @Assert\Range(
     *      min = 18,
     *      max = 90,
     *      minMessage = "La edad mínima es {{ limit }}",
     *      maxMessage = "La edad máxima es {{ limit }}",
     *      invalidMessage = "El valor introducido no es válido."
     * )
     */
    protected $age;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(
     *     message = "No es una fecha válida."
     * )
     */
    protected $birthDate;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 100,
     *      max = 300,
     *      minMessage = "La altura mínima es {{ limit }}",
     *      maxMessage = "La altura máxima es {{ limit }}",
     *      invalidMessage = "El valor introducido no es válido."
     * )
     */
    protected $height;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Email(
     *     message = "El email '{{ value }}' no es válido."     
     * )
     */
    protected $email;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(pattern="/^[0-9]{9,12}$/",      	
     *     message = "El telefono debe estar formado por entre 9 y 12 dígitos."
     * )
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"m", "f"},
     *  message = "Elige un genero válido.")
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "El número mínimo es {{ limit }}",
     *      maxMessage = "El número máximo es {{ limit }}"
     * )
     */
    protected $descends;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)     
     */
    protected $vehicle;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Language(message="El lenguaje ha de ser en formato unicode")
     */
    protected $preferredLanguage;
    
    /**
     * @ORM\Column(type="integer", nullable=true)     
     */
    protected $englishLevel;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Language(message="El lenguaje ha de ser en formato unicode")
     */
    protected $personalWebSite;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\CardScheme(
     *     schemes={"VISA","MASTERCARD","MAESTRO"},
     *     message="Tu número de tarjeta de crédido es inválido."
     * )
     */
     
    protected $cardNumber;
    
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Iban(
     *     message="Este no es un número válido de International Bank Account Number (IBAN)."
     * )
     */
    protected $IBAN;
    

    
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
     * Set name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Person
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Person
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Person
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
    	return $this->gender == 'm' ? 'Masculino' : 'Femenino';    	
    }

    /**
     * Set descends
     *
     * @param integer $descends
     *
     * @return Person
     */
    public function setDescends($descends)
    {
        $this->descends = $descends;

        return $this;
    }

    /**
     * Get descends
     *
     * @return integer
     */
    public function getDescends()
    {
        return $this->descends;
    }

    /**
     * Set vehicle
     *
     * @param boolean $vehicle
     *
     * @return Person
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }
    
    /**
     * Get vehicle
     *
     * @return string
     */
    public function getVehicle()
    {
    	//return $this->vehicle == true ? 'Si' : 'No';
    	return $this->vehicle;    	
    }

    /**
     * Has vehicle
     *
     * @return boolean
     */
    public function hasVehicle()
    {
    	return $this->vehicle;
    }

    /**
     * Set preferredLanguage
     *
     * @param string $preferredLanguage
     *
     * @return Person
     */
    public function setPreferredLanguage($preferredLanguage)
    {
        $this->preferredLanguage = $preferredLanguage;

        return $this;
    }

    /**
     * Get preferredLanguage
     *
     * @return string
     */
    public function getPreferredLanguage()
    {
        return $this->preferredLanguage;
    }

    /**
     * Set englishLevel
     *
     * @param integer $englishLevel
     *
     * @return Person
     */
    public function setEnglishLevel($englishLevel)
    {
        $this->englishLevel = $englishLevel;

        return $this;
    }

    /**
     * Get englishLevel
     *
     * @return integer
     */
    public function getEnglishLevel()
    {
    	$levels = Array('A1','A2','B1','B2','C1','C2');
        return $levels[$this->englishLevel+1];
    }

    /**
     * Set personalWebSite
     *
     * @param string $personalWebSite
     *
     * @return Person
     */
    public function setPersonalWebSite($personalWebSite)
    {
        $this->personalWebSite = $personalWebSite;

        return $this;
    }

    /**
     * Get personalWebSite
     *
     * @return string
     */
    public function getPersonalWebSite()
    {
        return $this->personalWebSite;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return Person
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set iBAN
     *
     * @param string $iBAN
     *
     * @return Person
     */
    public function setIBAN($iBAN)
    {
        $this->IBAN = $iBAN;

        return $this;
    }

    /**
     * Get iBAN
     *
     * @return string
     */
    public function getIBAN()
    {
        return $this->IBAN;
    }
}
