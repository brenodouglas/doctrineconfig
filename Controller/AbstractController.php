<?php

namespace RespectDoctrine\Controller;

use RespectDoctrine\Controller\Interface\InterfaceController;
use RespectDoctrine\Doctrine\Doctrine;

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
    
}