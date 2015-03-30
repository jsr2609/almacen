<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseManager
 *
 * @author jsr
 */

namespace SSA\UtilidadesBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Repository;


class BaseManager 
{
    private $doctrine;
    private $request;
    private $securityContext;
    private $router;
    private $session;
    
    public function __construct($doctrine, SecurityContext $securityContext, $router, Session $session)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->securityContext = $securityContext;
        $this->session = $session;
    }
    
    public function setRequest(Request $request = null) {
        $this->request = $request;
    }
    
    /**
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * 
     * @return EntityManager 
     */
    public function getManager()
    {
        return $this->doctrine->getManager();
    }
    
    /**
     * Mover a una carpeta estatica
     * 
    public static function  getUniqueId($length = 10)
    {
        $slug = md5(uniqid(rand(), true));
        $slug = substr($slug, 0, $length);        
        return $slug;
    }
     *
     */
    
    
    public function getBasePath()
    {
        return $this->request->getBasePath();
    }
    
    /**
     * 
     * @param string $url
     * @param array $options
     * @return string
     */
    public function generateUrl($url, $options = array())
    {
        return $this->router->generate($url, $options);
    }
    
    /**
     * 
     * @return SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }
    
    /**
     * $entityName
     * @param type $repository
     * @return Repository
     */
    public function getRepository($repository) 
    {
        return $this->getManager()->getRepository($repository);
    }
    
    public function addFlashMessage($type, $txt)
    {
        $this->request->getSession()->getFlashBag()->add(
            $type,
            $txt
        );
    }
    
    public function getSession()
    {
        return $this->session;
    }
    
    /**
     * Returns a NotFoundHttpException.
     *
     * This will result in a 404 response code. Usage example:
     *
     *     throw $this->createNotFoundException('Page not found!');
     *
     * @param string     $message  A message
     * @param \Exception $previous The previous exception
     *
     * @return NotFoundHttpException
     */
    public function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new NotFoundHttpException($message, $previous);
    }
    
    
    
}