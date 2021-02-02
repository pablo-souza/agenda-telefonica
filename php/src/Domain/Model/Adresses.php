<?php
namespace Sismoura\Agenda\Domain\Model;

use JsonSerializable;

class Adresses implements JsonSerializable
{
    private int $id;
    private Contacts $contact;
    private string $street;
    private string $neighborhood;
    private string $number;
    private string $city;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of street
     */ 
    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * Get the value of neighborhood
     */ 
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    /**
     * Get the value of number
     */ 
    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
        return $this;

    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;

    }
    public function jsonSerialize(){
        return (Object)[
            // 'id'            =>   $this->id,
            'street'        =>   $this->street,
            'neighborhood'  =>   $this->neighborhood,
            'number'        =>   $this->number,
            'city'          =>   $this->city
        ];
    }

    /**
     * Get the value of contact
     */ 
    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }
}