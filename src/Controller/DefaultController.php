<?php

namespace App\Controller;

use App\Service\FibonacciService; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    private FibonacciService $fibonacciService; 

    public function __construct(FibonacciService $fibonacciService)
    {
        $this->fibonacciService = $fibonacciService;
    }

    #[Route('/fibonacci/{number}', methods: ["GET"])] 
    public function checkFibonacciNumber(int $number): JsonResponse
    {
        $isFibonacci = $this->fibonacciService->isFibonacci($number);

        return new JsonResponse([
            'number' => $number,
            'is_fibonacci' => $isFibonacci,
            'message' => $isFibonacci ? 'Это число Фибоначчи' : 'Это не число Фибоначчи'
        ]);
    }

    #[Route('/simplicity', methods: ['GET'])]
    public function simple(): Response
    {
        return new Response('Simple! Easy! Great!');
    }
}
