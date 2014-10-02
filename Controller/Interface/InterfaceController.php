<?php
namespace RespectDoctrine\Controller\Interface;

interface InterfaceController 
{
    
    public function getDoctrine();
    public function getEntityManager();
    public function getRepository();
    
}