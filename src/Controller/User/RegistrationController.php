<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class RegistrationController
 * @package App\Controller\User
 */
class RegistrationController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $errors = $request->get('errors');
        return $this->renderForm('registration/index.html.twig', compact('errors'));
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    public function createUser(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $fields = ['name', 'email', 'password'];
        $errors = [];
        foreach ($fields as $field) {
            if (empty($request->get($field)))
                $errors[$field] = 'Required field';
        }
        if (!empty($errors))
            return $this->redirectToRoute('registration', ['errors' => $errors]);

        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setName($request->get('name'));
        $user->setEmail($request->get('email'));
        $user->setPassword($passwordHasher->hashPassword($user, $request->get('password')));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('registration');
    }

}
