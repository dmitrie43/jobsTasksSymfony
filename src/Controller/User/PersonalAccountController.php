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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render(
            "personal_account/index.html.twig", []
        );
    }
}