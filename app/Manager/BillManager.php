<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/10/16
 * Time: 23:30
 */

namespace Manager;


class BillManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('bill');
    }
    public function lastIdInsert()
    {
        $sql=('SELECT id FROM bill ORDER BY id DESC');
        $req=$this->dbh->query($sql);
        $data = $req->fetch();
        return $data['id'];
    }
    public function getBillForListing()
    {
        $req=$this->dbh->query('SELECT bi.id,DATE_FORMAT(bi.date_created,\'%d/%m/%Y \') AS date_created,cu.lastname,cu.firstname FROM bill as bi INNER JOIN customers as cu ON bi.id_customer = cu.id ORDER BY bi.id DESC ');
        return $req->fetchAll();
    }

    public function getBill($id)
    {
        $sql='
        SELECT b.information,b.pay,b.print,b.id,b.total,b.mileage,DATE_FORMAT(b.date_created,\'%d/%m/%Y \') AS date_created,cu.firstname,cu.lastname,cu.adress,cpa.VILLE as city,cpa.CP as zipcode,ca.matricule,cb.name as brand,m.name as model
        FROM bill as b 
        INNER JOIN customers as cu
        ON b.id_customer=cu.id
        INNER JOIN cp_autocomplete as cpa
        ON cu.id_city=cpa.id
        INNER JOIN cars as ca
        ON b.id_car=ca.id
        INNER JOIN car_brand as cb
        ON ca.id_car_brand=cb.id
        INNER JOIN model as m 
        ON ca.car_model=m.id
        WHERE b.id = :idBill
        ';
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idBill' => $id));
        return $req->fetch();
    }
    public function getBillsForCustomers($id){
        $sql="
        SELECT DATE_FORMAT(b.date_created,'%d/%m/%Y ') AS date_created,id,pay,total
        FROM bill as b 
        WHERE b.id_customer=:idCustomer
        ORDER BY date_created DESC 
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idCustomer' => $id));
        return $req->fetchAll();
    }

    public function getBillNoPayForCustomer($idCustomer)
    {
        $sql="
        SELECT id,total
        FROM bill as b 
        WHERE b.id_customer=:idCustomer AND b.pay='null'
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idCustomer' => $idCustomer));
        return $req->fetchAll();
    }

    public function deleteBill($idBill)
    {
        $req=$this->dbh->prepare('DELETE FROM bill WHERE id = :idBill');
        $req->execute(array('idBill' => $idBill));

        $req=$this->dbh->prepare('DELETE FROM bill_mounting WHERE id_bill = :idBill');
        $req->execute(array('idBill' => $idBill));

        $req=$this->dbh->prepare('DELETE FROM bill_other_service WHERE id_bill = :idBill');
        $req->execute(array('idBill' => $idBill));

        $req=$this->dbh->prepare('DELETE FROM bill_decalaminage WHERE id_bill = :idBill');
        $req->execute(array('idBill' => $idBill));
    }
}