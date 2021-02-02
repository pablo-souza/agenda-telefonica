<?php
namespace Sismoura\Agenda\Domain\Model;

use Doctrine\ORM\Query\AST\NewObjectExpression;
use Exception;
use JsonSerializable;
use RuntimeException;
use Sismoura\Agenda\Domain\Model\Contacts;
class Phones implements JsonSerializable
{
    private int $id;
    private Contacts $contact;
    private string $number;
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
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
        $number = preg_replace("/[^0-9]/", "",$number);
        if(empty($number)){
            throw new RuntimeException('Invalid phone number');
        }
        $this->number = $number;

    }

    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;

    }
    public function jsonSerialize(){
        return (Object)[
            'id'        => $this->id,
            'number'    => $this->number
        ];
    }
}