<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        $errors = $request->get('errors');
        return $this->render(
            "profile/index.html.twig", [
                'user' => $this->getUser(),
                'errors' => $errors,
            ]
        );
    }

    /**
     * @param UserRepository $userRepository
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @param Session $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateProfile(UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher, Session $session)
    {
        $fields = ['name', 'email', 'password'];
        $errors = [];
        foreach ($fields as $field) {
            if (empty($request->get($field)))
                $errors[$field] = 'Required field';
        }
        if (!empty($errors))
            return $this->redirectToRoute('profile', ['errors' => $errors]);

        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        $user->setName($request->get('name'));
        $user->setEmail($request->get('email'));
        $user->setPassword($passwordHasher->hashPassword($user, $request->get('password')));

        $userRepository->edit($user, true);

        $session->getFlashBag()->add(
            'success',
            'Success updating'
        );

        return $this->redirectToRoute('profile');
    }
}



