<?php
namespace Sismoura\Agenda\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use Sismoura\Agenda\Domain\Model\Adresses;
use Sismoura\Agenda\Domain\Model\Phones;
class Contacts implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $lestName;
    private $phones;
    private $address;

    public function __construct()
    {
      $this->phones  = new ArrayCollection();
    }
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

    }

    /**
     * Get the value of lestName
     */ 
    public function getLestName()
    {
        return $this->lestName;
    }

    public function setLestName($lestName)
    {
        $this->lestName = $lestName;

    }

    /**
     * Get the value of phones
     */ 
    public function getPhones():Collection
    {
        return $this->phones;
    }

    public function addPhone(Phones $phone)
    {
        $this->phones->add($phone);
        $phone->setContact($this);
        return $this;
    }
    public function removePhones(Phones $phones)
    {
        $this->phones = $phones;

    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(Adresses $address)
    {
        $this->address = $address;
        $this->address->setContact($this);
    }

    public function jsonSerialize(){
        return (Object)[
            'id'            =>   $this->id,
            'name'          =>   $this->name.$this->lestName,  
            'phones'        =>   $this->getPhones()->map(function(Phones $phone){
                                    return $phone->jsonSerialize();
                                 })->toArray(),
            'address'       => $this->getAddress()->jsonSerialize()
        ];
    }
}