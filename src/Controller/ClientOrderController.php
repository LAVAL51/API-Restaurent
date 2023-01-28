<?php

namespace App\Controller;

use App\Entity\ClientOrder;
use App\Form\ClientOrderType;
use App\Repository\ClientOrderRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class ClientOrderController extends AbstractController
{
  #[Route('/', name: 'app_client_order_index', methods: ['GET'])]
  public function index(ClientOrderRepository $clientOrderRepository): Response
  {
    return $this->render('client_order/index.html.twig', [
      'client_orders' => $clientOrderRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_client_order_new', methods: ['GET', 'POST'])]
  public function new(Request $request, ClientOrderRepository $clientOrderRepository): Response
  {
    $clientOrder = new ClientOrder();
    $form = $this->createForm(ClientOrderType::class, $clientOrder);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $clientOrder->setDateCommande(new DateTimeImmutable());
      $clientOrder->setStatus("Prise");
      $clientOrderRepository->save($clientOrder, true);

      return $this->redirectToRoute('app_client_order_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('client_order/new.html.twig', [
      'client_order' => $clientOrder,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_client_order_show', methods: ['GET'])]
  public function show(ClientOrder $clientOrder): Response
  {
    return $this->render('client_order/show.html.twig', [
      'client_order' => $clientOrder,
    ]);
  }

  #[Route('/{id}/edit', name: 'app_client_order_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, ClientOrder $clientOrder, ClientOrderRepository $clientOrderRepository): Response
  {
    $form = $this->createForm(ClientOrderType::class, $clientOrder);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $clientOrderRepository->save($clientOrder, true);

      return $this->redirectToRoute('app_client_order_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('client_order/edit.html.twig', [
      'client_order' => $clientOrder,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_client_order_delete', methods: ['POST'])]
  public function delete(Request $request, ClientOrder $clientOrder, ClientOrderRepository $clientOrderRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $clientOrder->getId(), $request->request->get('_token'))) {
      $clientOrderRepository->remove($clientOrder, true);
    }

    return $this->redirectToRoute('app_client_order_index', [], Response::HTTP_SEE_OTHER);
  }
}
