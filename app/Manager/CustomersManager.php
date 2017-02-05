<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 30/09/16
 * Time: 18:01
 */

namespace Manager;


class CustomersManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('customers');
    }

    /*
     * @return nom,prénom,ville du client
     */
    public function getCustomersList()
    {
        $sql="
        SELECT c.id as id,firstname,lastname,cp.VILLE as city
        FROM customers as c
        INNER JOIN cp_autocomplete as cp
        ON c.id_city=cp.id
        ORDER BY lastname
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array());
        return $req->fetchAll();
    }

    /*
     * retourn la liste des clients en fonction de la recherche
     *
     * @param string $search
     * @return array $customers
     */
    public function getCustomersSearchList($search)
    {
        $req=$this->dbh->prepare('SELECT id FROM customers WHERE lastname LIKE :search');
        $req->execute(array('search' => $search.'%'));
        return $req->fetchAll();
    }

    public function getCustomer($id)
    {
        $sql="
        SELECT c.id as id,firstname,lastname,email,adress,phone,date_created,cp.VILLE as city,cp.CP as zipcode,cp.id as idCity
        FROM customers as c
        INNER JOIN cp_autocomplete as cp
        ON c.id_city=cp.id
        WHERE c.id=:idCustomer
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('idCustomer'=>$id));
        return $req->fetch();
    }

    public function customerExist($newCustomer)
    {
        $sql="
        SELECT count(*)
        FROM customers as c
        WHERE firstname = :firstname
        AND lastname = :lastname
        AND id_city = :id_city
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('firstname'=>$newCustomer['firstname'],'lastname'=>$newCustomer['lastname'],'id_city' =>$newCustomer['id_city']));
        return $req->fetchColumn(0);
    }
}