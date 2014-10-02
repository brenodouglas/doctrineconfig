<?php
namespace   RespectDoctrine\Doctrine\Interface;

interface InterfaceDoctrine 
{
    
    public function getEntityManager();
    
    private function getConn();
    
    private function getConfig();
    
}