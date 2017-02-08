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
    private $clientManager;

    public function __construct()
    {
        $this->rdvManager = new \Manager\RdvManager();
        $this->clientManager = new \Manager\CustomersManager();
    }

    public function view(){
        if(isset($_GET['idClient'])){
            $clients = $this->clientManager->find($_GET['idClient']);
            $client['id'] = $clients['id'];
            $client['name'] = $clients['lastname'].' '.$clients['firstname'];
        }else{
            $client['id'] = 0;
        }
        $this->show('agenda/view',['client' => $client]);
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

    /**
     * add et edit rdv
     */
    public function addRdv(){
        $data = $_POST;
        $idEvent = $data['idEvent'];
        $explode = explode('/',$data['dateRdv']);
        $start = strtotime($explode[2].'-'.$explode[1].'-'.$explode[0].' '.$data['heureRdv'].':00');
        $end = $start+intval($data['dureeRdv']*60);
        $data = [
            'acier'         => $data['acier'],
            'pouce'         => $data['taille'],
            'nbr_pneu'      => $data['nbrPneu'],
            'livraison'     => $data['typeRdv'],
            'start'         => date('Y-m-d H:i:s',$start),
            'end'           => date('Y-m-d H:i:s',$end),
            'id_customer'   => $data['user'],
            'remarque'      => $data['remarque'],
            'inconnu'         => $data['inconnu']
        ];
        if($idEvent == ''){
            $this->rdvManager->insert($data);
        }else{
            $this->rdvManager->update($data,$idEvent);
        }

    }

    public function loadEvent(){
        $idEvent = $_GET['idEvent'];
        $event = $this->rdvManager->getEvent($idEvent);
        $event['dateRdv'] = date('d/m/Y',strtotime($event['start']));
        $start = strtotime($event['start']);
        $end = strtotime($event['end']);
        $duree = $end-$start;
        $event['debut'] = date('H:i',$start);
        $event['duree'] = $duree/60;
        $this->showJson($event);
    }
}