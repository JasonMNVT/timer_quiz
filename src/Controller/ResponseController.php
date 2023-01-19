<?php

namespace App\Controller;

use App\Entity\Response;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/response')]
class ResponseController extends AbstractController
{
    #[Route('/', name: 'app_response_index', methods: ['GET'])]
    public function index(ResponseRepository $responseRepository): BaseResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('response/index.html.twig', [
            'responses' => $responseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_response_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ResponseRepository $responseRepository): BaseResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        $response = new Response();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseRepository->save($response, true);

            return $this->redirectToRoute('app_response_index', [], BaseResponse::HTTP_SEE_OTHER);
        }

        return $this->renderForm('response/new.html.twig', [
            'response' => $response,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_response_show', methods: ['GET'])]
    public function show(Response $response): BaseResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('response/show.html.twig', [
            'response' => $response,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_response_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Response $response, ResponseRepository $responseRepository): BaseResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseRepository->save($response, true);

            return $this->redirectToRoute('app_response_index', [], BaseResponse::HTTP_SEE_OTHER);
        }

        return $this->renderForm('response/edit.html.twig', [
            'response' => $response,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_response_delete', methods: ['POST'])]
    public function delete(Request $request, Response $response, ResponseRepository $responseRepository): BaseResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        if ($this->isCsrfTokenValid('delete'.$response->getId(), $request->request->get('_token'))) {
            $responseRepository->remove($response, true);
        }

        return $this->redirectToRoute('app_response_index', [], BaseResponse::HTTP_SEE_OTHER);
    }
}
