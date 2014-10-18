<<?php
namespace RespectDoctrine\Hydrator;

interface InterfaceController 
{
    
    public function hydrate(array $data, &$object);
    public function extractArray($object);
    
}