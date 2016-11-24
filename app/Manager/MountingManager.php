<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 08/10/16
 * Time: 17:48
 */

namespace Manager;


class MountingManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('mounting');
    }

    public function getServicesListWithSize($size)
    {
        $req=$this->dbh->prepare('SELECT * FROM mounting WHERE size = :Size OR size = "0" ');
        $req->execute(array('Size' => $size));
        return $req->fetchAll();
    }
}