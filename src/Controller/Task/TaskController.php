<?php

namespace App\Controller\Task;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController extends AbstractController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('task/index.html.twig', []);
    }
}
