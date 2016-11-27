<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 21/10/16
 * Time: 14:59
 */

namespace Manager;


class BrandManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('car_brand');
    }
    /*
     * récupère la liste des marque auto classé par ordre alphabétique
     */
    public function getBrands()
    {
        $req=$this->dbh->query('SELECT * FROM car_brand ORDER BY name');
        return $req->fetchAll();
    }

    public function brandExist($brand){
        $sql="
        SELECT count(*) as nbr
        FROM car_brand as cb
        WHERE name=:brand
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('brand'=>$brand));
        return $req->fetchColumn(0);
    }
}