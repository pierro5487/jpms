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

    public function view(){

        $this->show('agenda/view');
    }

    public function eventLoad(){
        $start = date('Y-m-d',$_GET['start']);
        $end = date('Y-m-d',$_GET['end']);
        $options = 'start BETWEEN '."'".$start."'".' AND '."'".$end."'";
        $events = $this->rdvManager->getEvents($options);
        foreach ($events as $key => $event){
            if($event['livraison'] != 'decalaminage'){
                $title = $event['nbr_pneu'].' '.$event['acier'].' '.$event['pouce'].' '.'pouce'.' '.$event['remarque'];
                $events[$key]['title'] = $title;
            }else{
                $events[$key]['title'] = 'décalaminage';
            }

            unset($events[$key]['nbr_pneu']);
            unset($events[$key]['nbr_acier']);
            unset($events[$key]['nbr_pouce']);

            switch ($event['livraison']) {
                case 'livre':
                    $events[$key]['color'] = 'blue';
                    break;
                case 'non_livre':
                    $events[$key]['color'] = 'red';
                    break;
                case 'decalaminage':
                    $events[$key]['color'] = 'green';
                    break;
                case 'switch':
                    $events[$key]['color'] = 'orange';
                    break;
            }
        }
        /*-------creation title--------*/
        $this->showJson($events);
    }

    public function addRdv(){
        $data = $_POST;
        print_r($data);
        $explode = explode('/',$data['dateRdv']);
        //print_r($explode);
        $start = strtotime($explode[2].'-'.$explode[1].'-'.$explode[0].' '.$data['heureRdv'].':00');
        echo $data['idClient'];
        $end = $start+intval($data['dureeRdv']*60);
        $data = [
            'acier'         => $data['acier'],
            'pouce'         => $data['taille'],
            'nbr_pneu'      => $data['nbrPneu'],
            'livraison'     => $data['typeRdv'],
            'start'         => date('Y-m-d H:i:s',$start),
            'end'           => date('Y-m-d H:i:s',$end),
            'id_customer'   => $data['user'],
            'remarque'      => $data['remarque']
        ];

        $this->rdvManager->insert($data);
    }
}