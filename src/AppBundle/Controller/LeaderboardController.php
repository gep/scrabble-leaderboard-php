<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LeaderboardController extends Controller
{
    const LEADERS_MAX_RESULTS = 10;

    const MIN_GAMES_PLAYED = 3;

    /**
     * @Route("/leaderboard")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Leaderboard:index.html.twig', array(
            'leaders' =>  $this->getDoctrine()->getRepository(Player::class)
                ->getLeaderBoard(static::MIN_GAMES_PLAYED, static::LEADERS_MAX_RESULTS)
        ));
    }

    /**
     * @Route("/profile/{name}", name="profile")
     */
    public function profileAction(Player $player)
    {
        /** @var PlayerRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Player::class);

        return $this->render('AppBundle:Leaderboard:profile.html.twig', array(
            'player' => $player,
            'highest_score' => $repo->highestScore($player->getName()),
            'number_of_wins' => $repo->getNumberOfWins($player->getName()),
            'number_of_losses' => $repo->getNumberOfLosses($player->getName()),
            'avg_score' => $repo->averageScore($player->getName()),
        ));
    }

}
