<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class PersonalAccountController
 * @package App\Controller\User
 */
class PersonalAccountController extends AbstractController
{
    /**
     * Страница личного кабинета
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            "profile/index.html.twig", []
        );
    }
}