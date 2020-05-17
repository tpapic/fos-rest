<?php


namespace App\Controller;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/", name="home")
     */
    public function index()
    {
        $data = [
            'message' => 'Welcome to your new controller!',
        ];

        return $this->view($data, Response::HTTP_OK);
    }
}