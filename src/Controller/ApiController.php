<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/cities/{city}", name="app_api_cities")
     */
    public function getCities($city)
    { 

        $city = str_replace(' ', '+', strtolower($city));
        
        $req = sprintf($this->getParameter('api_address'), $city);
        
        $res = json_decode(file_get_contents($req), true);
        
        return $this->json($res,
            Response::HTTP_CREATED
        );
    }
}
