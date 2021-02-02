<?php

use Sismoura\Agenda\Domain\Model\Adresses;
use Sismoura\Agenda\Domain\Model\Contacts;
use Sismoura\Agenda\Domain\Model\Phones;
use Sismoura\Agenda\Infrastructure\Persistence\Helper\EntityManagerFactory;

require_once 'vendor/autoload.php';
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods:*");
header("Access-Control-Allow-Headers:*");

$url = explode("/",$_SERVER['REQUEST_URI']);

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$response=[];
switch($url[1]){
    case "contacts":
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $contactsRepository  = $entityManager->getRepository(Contacts::class);
                if(is_numeric($url[2]) && preg_replace("/[0-9]/", "",$url[2])==""){
                    try{
                        $response = $contactsRepository->find($url[2]);
                        if($response!=null){
                            $response = $response->jsonSerialize();
                        }else{
                             throw new RuntimeException("contact not id = {$url[2]} found"); 
                        }
                    }catch(RuntimeException $e){
                        $response['error'] = $e->getMessage();
                    }
                    
                }else{
                    $contactsList = $contactsRepository->findAll();
                    for($i = 0; $i<sizeof($contactsList);$i++){
                        $response[] = $contactsList[$i]->jsonSerialize();
                    }
                }
                echo json_encode($response);
                break;
            case "POST":
                if (!empty($url[2]) && !empty($url[3]) && !empty($url[4])){
                    if(preg_replace("/[0-9]/", "",$url[2])=="" && $url[3]=='phone'){
                        $contactsRepository  = $entityManager->getRepository(Contacts::class);
                        $contact = $contactsRepository->find($url[2]);
                        $phone = new Phones;
                        $phone->setNumber($url[4]);
                        $contact->addPhone($phone);
                        $entityManager->persist($phone);
                        $entityManager->flush();
                        echo $phone->getId();
                    }else{
                        http_response_code(400);
                    }
                    break;
                }

                $json = file_get_contents('php://input');
                $obj  = (Object)json_decode($json);
                $contact = new Contacts;
                $obj->name = explode(" ",$obj->name);
                $contact->setName($obj->name[0]);
                $obj->name = implode(" ",$obj->name);
                $contact->setLestName(str_replace($contact->getName(),"",$obj->name));
                $address = new Adresses;
                $entityManager->persist($address);
                $address->setStreet($obj->address->street);
                $address->setNumber($obj->address->number);
                $address->setNeighborhood($obj->address->neighborhood);
                $address->setCity($obj->address->city);
                $contact->setAddress($address);
                
                for($i = 0;$i<sizeof($obj->phones);$i++){
                    $phone = new Phones;
                    $phone->setNumber($obj->phones[$i]->number);
                    $entityManager->persist($phone);
                    $contact->addPhone($phone); 
                }
                $entityManager->persist($contact);
                $entityManager->flush();
                echo json_encode($contact->jsonSerialize());
                break;
            case "PUT":
                $contactsRepository  = $entityManager->getRepository(Contacts::class);
                if(is_numeric($url[2]) && preg_replace("/[0-9]/", "",$url[2])==""){
                    $json = file_get_contents('php://input');
                    try{
                        $contact = $contactsRepository->find($url[2]);
                        if($contact!=null){
                            $obj  = (Object)json_decode($json);
                            $obj->name = explode(" ",$obj->name);
                            $contact->setName($obj->name[0]);
                            $obj->name = implode(" ",$obj->name);
                            $contact->setLestName(str_replace($contact->getName(),"",$obj->name));
                            $contact->getAddress()
                            ->setStreet($obj->address->street)
                            ->setNumber($obj->address->number)
                            ->setNeighborhood($obj->address->neighborhood)
                            ->setCity($obj->address->city);
                            $entityManager->flush();
                        }else{
                             throw new RuntimeException("contact not id = {$url[2]} found"); 
                        }
                    }catch(RuntimeException $e){
                        $response['error'] = $e->getMessage();
                        http_response_code(400);
                    }
                }
                break;
            case "DELETE":
                if(is_numeric($url[2]) && preg_replace("/[0-9]/", "",$url[2])==""){
                    $contact = $entityManager->getReference(Contacts::class,$url[2]);
                    $entityManager->remove($contact);
                    $entityManager->flush();
                }
            break;
        }
        break;
    case "phone":
        switch ($_SERVER['REQUEST_METHOD']) {
            case "PUT":
                if(is_numeric($url[2]) && preg_replace("/[0-9]/", "",$url[2])=="" && !empty($url[3])){
                    try{
                        $phonesRepository  = $entityManager->getRepository(Phones::class);
                        $phone = $phonesRepository->find($url[2]);
                        if(empty($phone)){
                            throw new RuntimeException("Invalid phone id={$url[2]}");
                        }
                        $phone->setNumber($url[3]);
                        $entityManager->flush();
                    }catch(RuntimeException $e){
                        $response['error'] = $e->getMessage();
                        http_response_code(400);
                    }
                }
                break;
            case "DELETE":
                if(is_numeric($url[2]) && preg_replace("/[0-9]/", "",$url[2])==""){
                    $phone = $entityManager->getReference(Phones::class,$url[2]);
                    $entityManager->remove($phone);
                    $entityManager->flush();
                }
            break;
        }
        break;
}