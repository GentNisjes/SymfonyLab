<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\BookRepository;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CouBooksController extends AbstractController{

    private EntityManagerInterface $entityManager;
    private FeedbackRepository $feedbackRepo;

    public function __construct(EntityManagerInterface $entityManager, FeedbackRepository $feedbackRepo)
    {
        $this->entityManager = $entityManager;
        $this->feedbackRepo = $feedbackRepo;
    }


    #[Route('/', name: 'home')]
    public function home(FeedbackRepository $feedbackRepo): Response
    {
        $feedbacks = $feedbackRepo->findAllFeedback();
        return $this->render('coubooks/index.html.twig', [
            'feedbacks' => $feedbacks,
        ]);
    }

    #[Route(path: '/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('about/index.html.twig');
    }

    #[Route(path: '/courses', name: 'courses')]
    public function courses(BookRepository $bookRepo): Response
    {
        $books = $bookRepo->findAll();
        return $this->render('courses/index.html.twig', [
            'books' => $books
        ]);
    }

    #[Route('/feedback/delete/{id}', name: 'feedback_delete')]
    public function delete(int $id): RedirectResponse
    {
        $feedback = $this->feedbackRepo->find($id);

        if (!$feedback) {
            $this->addFlash('error', 'Feedback not found');
            return $this->redirectToRoute('home');
        }

        $this->entityManager->remove($feedback);
        $this->entityManager->flush();

        $this->addFlash('success', 'Feedback deleted successfully');
        return $this->redirectToRoute('home');
    }



    #[Route('/feedback/add', name: 'feedback_add')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($feedback);
            $entityManager->flush();

            $this->addFlash('success', 'Feedback saved successfully!');
            return $this->redirectToRoute('feedback');
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
