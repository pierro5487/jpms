<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 21/10/16
 * Time: 15:35
 */

namespace Manager;


class ModelManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('model');
    }

    public function modelExist($model,$idBrand){
        $sql="
        SELECT count(*) as nbr
        FROM model 
        WHERE name = :model 
        AND id_brand = :idBrand 
        ";
        $req=$this->dbh->prepare($sql);
        $req->execute(array('model'=>$model,'idBrand'=>$idBrand));
        return $req->fetchColumn(0);
    }
}