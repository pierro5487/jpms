<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 21/12/16
 * Time: 21:29
 */

namespace Manager;


class RdvManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('rdv');
    }

    public function getRdvForWeek($TSLundiSemChoix)
    {
        $sql='
        SELECT cu.id as id,day,debut,fin,id_customer,duree,livraison,lastname,phone,acier,pouce,nbr_pneu
        FROM rdv  
        INNER JOIN customers as cu 
        ON cu.id = rdv.id_customer
        WHERE day > :debutSemaine AND day < :finSemaine
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array(
            'debutSemaine' => date('Y-m-d',$TSLundiSemChoix),
            'finSemaine'   => date('Y-m-d',strtotime('+ 7 day',$TSLundiSemChoix))
        ));
        return $req->fetchAll();
    }
    public function getEvents($options){
        $sql='
        SELECT *,rdv.id as idEvent
        FROM rdv   
        INNER JOIN customers as cu 
        ON cu.id = rdv.id_customer
        ';
        if(!empty($options)){
            $sql .= 'WHERE '.$options;
        }
        $req=$this->dbh->prepare($sql);
        $req->execute(array(
            /*'debutSemaine' => date('Y-m-d',$TSLundiSemChoix),
            'finSemaine'   => date('Y-m-d',strtotime('+ 7 day',$TSLundiSemChoix))*/
        ));
        return $req->fetchAll();
    }

    public function getEvent($idEvent){
        $sql='
        SELECT *,rdv.id as idEvent
        FROM rdv  
        INNER JOIN customers as cu 
        ON cu.id = rdv.id_customer
        WHERE rdv.id = :idEvent
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array(
            'idEvent' => $idEvent,
        ));
        return $req->fetch();
    }
}