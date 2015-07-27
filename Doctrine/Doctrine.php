<?php

namespace RespectDoctrine\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * @package Doctrine
 * @author Breno Douglas <bdouglasans@gmail.com>
 */
class Doctrine implements InterfaceDoctrine 
{
    
    /**
     *
     * @var EntityManager
     */
    private static $entityManager;
    
    /**
     * @var String
     */
    private static $dir;
    
    /** 
     * @var String
     */
    private $config;

    /**
     * @var array
     */
    private $filters;

    /**
     * @var boolean
     */
    public static $isDevMode = true;
    
    /**
     * Get EntityManage for DataBase
     * @param String dataBase
     * @return EntityManager
     */
    public function getEntityManager($dataBase = null)
    {
         try {
            if(isset(self::$entityManager)){
                return self::$entityManager;          
            } else {
                $conn = $this->getConn($dataBase);
                $config = $this->getConfig();
                self::$entityManager = EntityManager::create($conn, $config);

                foreach ($this->filters as $filter)
                    self::$entityManager->getFilters()->enable($filter);
            }
        } catch(\Exception $e){
            echo $e->getMessage();die;
        }

        return self::$entityManager;
        
    }
    
    /**
     * Get configuration of database 
     * @param String $dataBaseName
     * @return array
     */
    private function getConn($dataBaseName = null)
    {
        $conn = require self::$dir;
        
        $dataBase = $conn['database'];
        
        if (! isset($dataBaseNam))
            $this->config = $dataBase[$dataBase['default']];
        else
            $this->config = $dataBase[$dataBaseName];

        return $this->config;
    }
    
    /**
    * Create config for metadata and annotation config in dotrine
    * @return AnnnotationMetadataConfiguration
    */
    private function getConfig()
    {   
        if (empty(self::$dir))
            throw new \Exception("Informe o diretorio que se encontra o config");
        
        $config = require self::$dir;
        
        $doctrineSetup = (object) $config['doctrine'];
        
        $setup = Setup::createAnnotationMetadataConfiguration($doctrineSetup->entity, self::$isDevMode);
        $setup->setProxyDir($doctrineSetup->metadata);
        
        /**Create cache region and factory **/
        $cache = new \Doctrine\Common\Cache\ApcCache;
        $cacheRegionConfiguration = new \Doctrine\ORM\Cache\RegionsConfiguration(); 
        $factory = new \Doctrine\ORM\Cache\DefaultCacheFactory($cacheRegionConfiguration, $cache); 
        
        $setup->setSecondLevelCacheEnabled(); 
        $setup->getSecondLevelCacheConfiguration()->setCacheFactory($factory);

        $setup->addCustomStringFunction("SOUNDEX", 'RespectDoctrine\Doctrine\Functions\SoundexFunction');
        $setup->addCustomStringFunction("MATCH", 'RespectDoctrine\Doctrine\Functions\MatchAgainst');
        $setup->addCustomNumericFunction("LEVENSHTEIN", 'RespectDoctrine\Doctrine\Functions\LevenshteinFunction');

        $filters = $doctrineSetup->filters;
        $this->filters = [];

        foreach ($filters as $name => $filter) {
            $setup->addFilter($name, $filter);
            $this->filters[] = $name;
        }
        
        return $setup;
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