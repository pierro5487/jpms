<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 20/10/16
 * Time: 15:11
 */

namespace Manager;


class BillsGroupManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('bills_group');
    }

    /*
     * retourne la liste de facture groupé que possede un client
     * @param int $id l'id du client
     * @return array list des facture groupé
     */
    public function getListBillsGroupForCustomer($idCustomer)
    {
        $sql="
        SELECT *
        FROM bills_group as bg
        WHERE bg.id_customer=:idCustomer
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idCustomer'=>$idCustomer));
        return $req->fetchAll();
    }

    public function lastIdInsert()
    {
        $sql=('SELECT id FROM bills_group ORDER BY id DESC');
        $req=$this->dbh->query($sql);
        $data = $req->fetch();
        return $data['id'];
    }

    /*
     * retourne l'id de la facture groupé non payé par rapport au client(si elle existe)
     */
    public function getBillGroupNoPayForCustomer($idCustomer)
    {
        $sql="
        SELECT id
        FROM bills_group as bg
        WHERE bg.id_customer=:idCustomer AND pay=0
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idCustomer'=>$idCustomer));
        return $req->fetch();
    }

    public function getBillGroupInfo($idBillGroup){
        $sql="
        SELECT bg.id as id,DATE_FORMAT(bg.date_created,'%d/%m/%Y ') as date_created,c.lastname,c.firstname,c.adress,cpa.CP as zipcode,cpa.VILLE as city,bg.pay,bg.total,bg.print
        FROM bills_group as bg
        INNER JOIN customers as c
        ON bg.id_customer= c.id
        INNER JOIN cp_autocomplete as cpa
        ON c.id_city=cpa.id
        WHERE bg.id=:idBill
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBill'=>$idBillGroup));
        return $req->fetch();
    }
}