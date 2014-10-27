<?php
namespace RespectDoctrine\Controller\Di;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DiHelper 
{	

	private static $loader;
	private static $container;
	private static $configDir;

	public static function registerConfig($dirConfig) 
	{	
		$services = self::extractConfig($dirConfig);

		self::$container = new ContainerBuilder();
		self::$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
		
		foreach($services as $service){
			if(file_exists($service)) {
				self::$loader->load('services.yml');
			}
		}
	}

	public function get($service)
	{
		return self::$container->get($service);
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