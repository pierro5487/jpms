<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/10/16
 * Time: 23:41
 */

namespace Manager;


class BillOtherServiceManager extends \W\Manager\Manager
{
	/*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('bill_other_service');
    }

    public function getOtherServices($id)
    {
    	 $sql='
        SELECT *
        FROM bill_other_service as bos
        INNER JOIN other_service as os 
        ON bos.id_other_service=os.id
        WHERE bos.id_bill = :idBill
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBill' => $id ));
        return $req->fetchAll();
    }
}