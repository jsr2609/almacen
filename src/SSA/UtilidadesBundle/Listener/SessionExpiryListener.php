<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionExpiryListener
 *
 * @author jsr
 */

namespace SSA\UtilidadesBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionExpiryListener 
{
    private $session;
    private $maxIdleTime;
    
    public function __construct(Session $session, $maxIdleTime = 0)
    {
        $this->session = $session;
        $this->maxIdleTime = $maxIdleTime;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Only operate on the master request
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        
        if($this->maxIdleTime > 0) {
        
            $request = $event->getRequest();

            if (!$request->hasSession()) {
                return;
            }

            $session = $request->getSession();
            $session->start();
            $metadataBag = $session->getMetadataBag();
            $lastUsed = $metadataBag->getLastUsed();
            if ($lastUsed === null) {
                // the session was created just now
                return;
            }
            $lapse = time() - $lastUsed;
            
            if($lapse > $this->maxIdleTime) {
                $session->invalidate();
                $session->getFlashBag()->set('danger', 'La sesión ha expirado por inactividad.');
                return;
            }
        }
        
        return;        
    }
}
