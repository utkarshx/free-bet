<?php

namespace BettingSas\Bundle\CompetitionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BettingSas\Bundle\CompetitionBundle\Document\Competition;

/**
 * Description of ListController
 *
 * @author jobou
 */
class CompetitionController extends Controller
{
    /**
     * List all competition
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $competitions = $this->get('betting_sas.competition.manager')
            ->getRepository()
            ->findAllOrderedByDate();

        return $this->render('BettingSasCompetitionBundle:Competition:list.html.twig', array(
            'competitions' => $competitions
        ));
    }

    /**
     * View competition detail
     *
     * @param \BettingSas\Bundle\CompetitionBundle\Document\Competition $competition
     *
     * @return \
     */
    public function viewAction(Competition $competition)
    {
        // TODO : remove hack to change view template according to competition type.
        // TODO : implements a template guesser service
        $type = \Doctrine\Common\Util\Inflector::classify($competition->getType());

        // Load all events of the competition
        // We suppose that the number of event is always small so it does not cost much to manage all at once
        $events = $this->get('betting_sas.competition.manager')
            ->getEventRepository()
            ->findBy(array('competition.id'=>$competition->getId()));

        return $this->render('BettingSas'.$type.'Bundle::view.html.twig', array(
            'competition' => $competition,
            'events' => $events
        ));
    }
}
