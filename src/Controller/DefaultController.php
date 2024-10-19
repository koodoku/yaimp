<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use App\Entity\Students;
use App\Service\GreetingService;
use App\Service\IsPrimeService;
// use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController  extends AbstractController
{
    private IsPrimeService $isPrimeService;

    public function __construct(IsPrimeService $isPrimeService)
    {
        $this->isPrimeService = $isPrimeService;
    }

    #[Route('/prime/{number}', methods: ["GET"])]
    public function checkPrimeNumber($number): JsonResponse
    {
        $isPrime = $this->isPrimeService->isPrime($number);


        return new JsonResponse([
            'number' => $number,
            'is_prime' => $isPrime,
            'message' => $isPrime ? 'Это простое число' : 'Это составное число'
        ]);
    }



    #[Route('/simplicity', methods: ['GET'])]
    public function simple(): Response
    {
        return new Response('Simple! Easy! Great!');
    }


}