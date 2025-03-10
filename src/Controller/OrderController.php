<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\OrderType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderController extends AbstractController
{
    #[Route('/order/{step}', name: 'order_step', requirements: ['step' => '\d+'], defaults: ['step' => 1])]
    public function order(int $step, Request $request, SessionInterface $session, BookRepository $bookRepository): Response
    {
        // Stap 1: Vraag de fase en e-mail op
        if ($step === 1) {
            $form = $this->createForm(OrderType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $session->set('fase', $data['fase']);
                $session->set('email', $data['email']);

                return $this->redirectToRoute('order_step', ['step' => 2]);
            }

            return $this->render('order/step1.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        // Stap 2: Haal de boeken op gebaseerd op de fase
        if ($step === 2) {
            $fase = $session->get('fase');
            if (!$fase) {
                return $this->redirectToRoute('order_step', ['step' => 1]);
            }

            // Ophalen van boeken via repository
            $books = $bookRepository->findByFase($fase);

            return $this->render('order/step2.html.twig', [
                'books' => $books,
            ]);
        }

        // Stap 3: Bevestiging tonen
        if ($step === 3) {
            $selectedBooks = $request->query->get('selected_books', []);
            $session->set('selected_books', $selectedBooks);

            return $this->render('order/step3.html.twig', [
                'books' => $selectedBooks,
            ]);
        }

        return $this->redirectToRoute('order_step', ['step' => 1]);
    }
}
