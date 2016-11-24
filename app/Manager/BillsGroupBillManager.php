<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 20/10/16
 * Time: 16:27
 */

namespace Manager;


class BillsGroupBillManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('bills_group_bill');
    }
    public function deleteLink($idBillGroupNoPay)
    {
        $sql="DELETE FROM bills_group_bill WHERE id_bills_group = :idBillGroup";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBillGroup'=>$idBillGroupNoPay));
    }
    public function getBillGroupListInfo($idBillGroup)
    {
        $sql="
        SELECT b.information,bgb.id,bgb.id_bill,b.mileage,DATE_FORMAT(b.date_created,'%d/%m/%Y ')as date_created,ca.matricule,cb.name as brand,m.name as model,b.total
        FROM bills_group_bill as bgb
        INNER JOIN bill as b
        ON bgb.id_bill=b.id
        INNER JOIN cars as ca
        ON ca.id=b.id_car
        INNER JOIN car_brand as cb
        ON cb.id=ca.id_car_brand
        INNER JOIN model as m 
        ON m.id=ca.car_model
        WHERE bgb.id_bills_group=:idBillGroup
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBillGroup'=>$idBillGroup));
        return $req->fetchAll();
    }
}