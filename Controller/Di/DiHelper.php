<?php
namespace RespectDoctrine\Controller\Di;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DiHelper 
{	

	private static $loader;
	private static $container;
	private static $configDir;

	public static function registerConfig($dirConfig, $type = "yml") 
	{		
		$services = self::extractConfig($dirConfig);
		
		self::$container = new ContainerBuilder();

		switch ($type) {
			case 'xml':
				self::$loader = new XmlFileLoader(self::$container, new FileLocator(__DIR__));
				break;
			
			case 'php':
				self::$loader = new PhpFileLoader(self::$container, new FileLocator(__DIR__));
				break;

			default:
				self::$loader = new YamlFileLoader(self::$container, new FileLocator(__DIR__));
				break;
		}
		
		
		foreach($services as $service){

			if(file_exists($service)) {
				self::$loader->load($service);
			}
		}
		
		self::$container->compile();
	}

	public function get($service)
	{
		return self::$container->get($service);
	}

	public function getContainer()
	{
		return self::$container;
	}

	private static function extractConfig($dirConfig) 
	{	
		if(file_exists($dirConfig)) {
			$config = require_once ($dirConfig);
			return $config['container']['services'];
		} 

		return [];
	}


}