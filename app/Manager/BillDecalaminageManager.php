<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 28/10/16
 * Time: 16:24
 */

namespace Manager;


class BillDecalaminageManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('bill_decalaminage');
    }
    public function getDecalaminageServicesForBill($id)
    {
        $sql='
        SELECT *
        FROM bill_decalaminage as bd
        INNER JOIN decalaminage as d
        ON bd.id_decalaminage=d.id
        WHERE bd.id_bill = :idBill
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBill' => $id ));
        return $req->fetchAll();
    }
}