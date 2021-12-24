<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="loan_index", methods={"GET"})
     */
    public function index(LoanRepository $loanRepository): Response
    {
        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{book_id}", name="loan_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, $book_id): Response
    {
        $loan = new Loan();
        $book = $entityManager->getRepository(Book::class)->find($book_id);
        $loan->setBook($book);
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loan->setLoanDate(new \DateTime());
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_show", methods={"GET"})
     */
    public function show(Loan $loan): Response
    {
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    /**
     * @Route("/return/{id}", name="loan_return", methods={"GET"})
     */
    public function return(Loan $loan, EntityManagerInterface $entityManager): Response
    {
        $loan->setReturnDate(new \DateTime());
        $entityManager->persist($loan);
        $entityManager->flush();

        return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/edit", name="loan_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Loan $loan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_delete", methods={"POST"})
     */
    public function delete(Request $request, Loan $loan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
    }
}
