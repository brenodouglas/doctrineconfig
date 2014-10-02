<?php
namespace RespectDoctrine\Controller;

interface InterfaceController 
{
    
    public function getDoctrine();
    public function getEntityManager();
    public function getRepository($repository);
    
}