<?php
namespace   RespectDoctrine\Doctrine;

interface InterfaceDoctrine 
{
    
    public function getEntityManager();
    
    private function getConn();
    
    private function getConfig();
    
}