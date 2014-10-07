<?php

namespace RespectDoctrine\Doctrine;

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

/**
 * @package Doctrine
 * @author Breno Douglas <bdouglasans@gmail.com>
 */
class DoctrineDm
{
    /**
     *
     * @var DocumentManager
     */
    private static $documentManager;
    
    /** 
     * @var String
     */
    private $config;

    
    /**
     * Get EntityManage for DataBase
     * @param String dataBase
     * @return EntityManager
     */
    public function getDocumentManager()
    {
         try {
            if(isset(self::$documentManager)){
                return self::$documentManager;          
            } else {
                $conf = $this->getConn();
                self::$documentManager = DocumentManager::create(new Connection(), $conf);
            }
        } catch(\Exception $e){
            echo $e->getMessage();die;
        }
        
        return self::$documentManager;
        
    }
    
    /**
     * Get configuration of database 
     * @param String $dataBaseName
     * @return array
     */
    private function getConn()
    {   
        AnnotationDriver::registerAnnotationClasses();
        
        $conn = require self::$dir;
        
        $dataBase = (object) $conn['mongodb'];
        
        $config = new Configuration();
        $config->setProxyDir($dataBase->dirProxy);
        $config->setProxyNamespace($dataBase->namespaceProxy);
        $config->setHydratorDir($dataBase->dirHydrator);
        $config->setHydratorNamespace($dataBase->namespaceHydrator);
        $config->setMetadataDriverImpl(AnnotationDriver::create($dataBase->entityDir));
    }
  
    /**
     *
     * @param String
     */
    public static function setConfigDir($dir) 
    {
        self::$dir = $dir;
    }
    
     /**
     *
     * @param String
     */
    public static function setIsDevMode($devMode) 
    {
        self::$isDevMode = $devMode;
    }
    
}
