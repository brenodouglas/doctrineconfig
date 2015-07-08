<?php
namespace RespectDoctrine\Hydrator;

interface InterfaceHydrator
{
    
    public function hydrate(array $data, &$object);
    public function extractArray($object);
    
}