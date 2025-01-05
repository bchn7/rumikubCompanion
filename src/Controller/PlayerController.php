<?php

namespace App\Controller;

use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/player', name: 'player')]
    public function index(PlayerService $playerService): Response
    {
        $players = $playerService->getAllPlayers();
        return $this->render('Player/player.html.twig', [
            'players' => $players
        ]);
    }

    #[Route('/player/add', name: 'add_player', methods: ['GET', 'POST'])]
    public function add(Request $request, PlayerService $playerService): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $playerService->addPlayer($name);
            $this->addFlash('success', 'Player added successfully!');
            return $this->redirectToRoute('player');
        }
        return $this->render('Player/add_player.html.twig');
    }

    #[Route('/player/add-points', name: 'rummikub_add_points', methods: ['GET', 'POST'])]
    public function addPoints(Request $request, PlayerService $playerService): Response
    {
        if ($request->isMethod('POST')) {
            // Get the points data from the form
            $pointsData = $request->request->all('points'); // 'all' method to get the array of points

            $zeroPointPlayer = null;  // To track the player with 0 points
            $negativeSum = 0;  // To sum the negative points

            // First pass: Check for the player with 0 points and sum the negative points from others
            foreach ($pointsData as $playerName => $points) {
                // Skip the player who has 'x' (indicating no points)
                if ($points === 'x') {
                    $playerService->addPoints(0, $playerName, false);  // Mark player as not playing
                    continue;
                }

                $points = (int) $points;

                if ($points < 0) {
                    $negativeSum += abs($points);  // Sum the absolute value of negative points
                } elseif ($points === 0) {
                    $zeroPointPlayer = $playerName;  // Identify the player with 0 points
                }
            }

            // Second pass: Add points to each player
            foreach ($pointsData as $playerName => $points) {
                // Skip the player who has 'x' (indicating no points)
                if ($points === 'x') {
                    continue;
                }

                $points = (int) $points;

                if ($playerName === $zeroPointPlayer) {
                    // If this is the player with 0 points, assign them the reversed sum of negative points
                    $playerService->addPoints($negativeSum, $playerName);
                } else {
                    // For other players, just add the points normally
                    $playerService->addPoints($points, $playerName);
                }
            }

            return $this->redirectToRoute('player');  // Redirect after processing
        }

        // Handle GET request to render the form
        $players = $playerService->getAllPlayers();
        return $this->render('Player/add_points.html.twig', [
            'players' => $players
        ]);
    }
}