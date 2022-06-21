<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller\User
 */
class AuthController extends AbstractController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            'auth/index.html.twig', []
        );
    }
}
