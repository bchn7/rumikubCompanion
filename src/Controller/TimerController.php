<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimerController extends AbstractController
{
    #[Route('/timer', name: 'timer_home')]
    public function index(): Response
    {
        return $this->render('Timer/timer.html.twig', [
        ]);
    }
}