<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/10/16
 * Time: 23:41
 */

namespace Manager;


class BillServiceManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('bill_mounting');
    }

    public function getMountingServicesForBill($id)
    {
        $sql='
        SELECT *
        FROM bill_mounting as bm
        INNER JOIN mounting as m 
        ON bm.id_mounting=m.id
        WHERE bm.id_bill = :idBill
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBill' => $id ));
        return $req->fetchAll();
    }
}