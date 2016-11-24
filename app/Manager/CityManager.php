<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/10/16
 * Time: 23:30
 */

namespace Manager;


class CityManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('cp_autocomplete');
    }

    public function getCityList($zipcode)
    {
        $sql='
        SELECT id,CP,VILLE
        FROM cp_autocomplete as cp 
        WHERE cp.CP = :zipcode
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array('zipcode' => $zipcode));
        return $req->fetchAll();
    }
}