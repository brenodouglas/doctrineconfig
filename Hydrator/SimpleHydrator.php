<?php
namespace RespectDoctrine\Hydrator;

/**
* @author Breno Douglas <bdouglasans@gmail.com>
*/
class SimpleHydrator implements InterfaceHydrator
{
    
    /**
     * Hydrate class Entity
     * @param array $data value for hydrate in object
     * @param Object &$object 
     */
    public function hydrate(array $data, &$object) 
    {
        foreach($data as $key => $value) {
            $methodName = $this->resolveSetNameMethod($key, $object);
            
            if($methodName !== null) {
                $object->$methodName($value);
            }
        }
    }   
    
    /**
     * Extract array of var in object
     * @param   Object $object
     * @returns array Array extracted of the object
     */
    public function extractArray($object)
    {
        $arrayCollection = new \ArrayIterator();
        $reflection = new \ReflectionClass($object);
        
        $vars = array_keys($reflection->getdefaultProperties());
        
        foreach($vars as $key) {
            $value = $this->resolveGetNameMethod($key, $object);
            
            if($value !== null) {
                $arrayCollection->offsetSet($key, $value);
            }
        }
        
        return $arrayCollection->getArrayCopy();
    }
    
    private function resolveSetNameMethod($name, $object)
    {
        $name = "set".ucfirst($name);
        
        if(! method_exists($object, $name)){
            $name = null;
        }
        
        return $name;
    }
    
    private function resolveGetNameMethod($name, $object) 
    {
        $name = "get".ucfirst($name);
        $value = null;
        
        if( method_exists($object, $name)) { 
            $value = $object->$name();
        }
        
        return $value;
    }
}