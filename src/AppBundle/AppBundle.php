<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function boot()
    {
        $this->cargarParametrosTCPDF();
    }
    
    private function cargarParametrosTCPDF()
    {
        if (!$this->container->hasParameter('white_october_tcpdf.tcpdf')) {
            return;
        }
        
        $config = $this->container->getParameter('white_october_tcpdf.tcpdf');
        
        foreach ($config as $k => $v)
        {
            $constKey = strtoupper($k);
            if (preg_match("/^pdf_/i", $k)) {
                if (!defined($constKey)) {
                    define($constKey, $v);
                }
            }
        }
    }
}
