<?php

namespace App\Controller\Task;

use App\Entity\Task;
use App\Entity\User;
use App\Message\TaskMessage;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isInstanceOf;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController extends AbstractController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $tasks = $this->taskRepository->findBy(['user_id' => $this->getUser()->getId()]);
        return $this->render('task/index.html.twig', compact('tasks'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newTask(Request $request): Response
    {
        $errors = $request->get('errors');
        return $this->render('task/task_create.html.twig', compact('errors'));
    }

    /**
     * @param Request $request
     * @param Session $session
     * @param MessageBusInterface $bus
     * @param ManagerRegistry $doctrine
     * @return Response
     * @throws \Exception
     */
    public function createTask(Request $request, Session $session): Response
    {
        $fields = ['title'];
        $errors = [];
        foreach ($fields as $field) {
            if (empty($request->get($field)))
                $errors[$field] = 'Required field';
        }
        if (!empty($errors))
            return $this->redirectToRoute('task_new', ['errors' => $errors]);

        $user = $this->getUser();

        $task = new Task();
        $task->setTitle($request->get('title'));
        $task->setDateExpiration(new \DateTime($request->get('date_to_expiration')));
        $task->setDescription($request->get('description'));
        $task->setUserId($user);

        $this->taskRepository->add($task, true);

        $session->getFlashBag()->add(
            'success',
            'Successfully created'
        );

        return $this->redirectToRoute('task_new');
    }
}
