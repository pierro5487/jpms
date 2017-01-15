<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/12/16
 * Time: 14:24
 */

namespace Controller;

use MongoDB\Driver\Manager;
use \W\Controller\Controller;

class AgendaController extends Controller
{
    private $rdvManager;

    public function __construct()
    {
        $this->rdvManager = new \Manager\RdvManager();
    }

    public function view($semChoix,$anneeChoix){

        $this->show('agenda/view',[]);
    }
    public function eventLoad(){
        $start = date('Y-m-d',$_GET['start']);
        $end = date('Y-m-d',$_GET['end']);
        $options = 'start BETWEEN '."'".$start."'".' AND '."'".$end."'";
        $events = $this->rdvManager->getEvents($options);
        foreach ($events as $key => $event){
            $title = $event['nbr_pneu'].' '.$event['acier'].$event['pouce'];
            $events[$key]['title'] = $title;
            unset($events[$key]['nbr_pneu']);
            unset($events[$key]['nbr_acier']);
            unset($events[$key]['nbr_pouce']);
        }
        /*-------creation title--------*/
        $this->showJson(['events' => $events]);
    }
}