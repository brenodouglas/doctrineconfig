<?php

namespace RespectDoctrine\Controller;

use RespectDoctrine\Doctrine\Doctrine;
use RespectDoctrine\Doctrine\DoctrineDm;
use RespectDoctrine\Controller\Di\DiHelper;

/**
 * @package Controller
 * @author Breno Douglas <bdouglasans@gmail.com>
 */
abstract class AbstractController implements InterfaceController 
{
    
    /**
     * @var String
     */
    protected $dataBase;
    
    /**
     * @return Doctrine
     */
    public function getDoctrine()
    {
        return new Doctrine($dataBase);
    }
    
    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return (new Doctrine($dataBase))->getEntityManager();
    }
    
    /**
     *
     * @return DoctrineDm
     */
    public function getDoctrineDocument() 
    {
        return new DoctrineDm();
    }
    
    /**
     *
     * @return DocumentManager
     */
    public function getDocumentManager() 
    {
        return (new DoctrineDm())->getDocumentManager();
    }
    
    /**
     * @param string
     * @return EntityRepository
     */
    public function getRepository($repository)
    {
        $em = (new Doctrine($dataBase))->getEntityManager();
        return $em->getRepository($repository);
    }
    
    public function setDataBase($dataBase) {
        $this->dataBase = $dataBase;
    }
    
    public function getService($service) 
    {
        return (new DiHelper())->get($service);
    }

    public function getContainer()
    {
        return (new DiHelper())->getContainer();
    }
}
