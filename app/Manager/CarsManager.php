<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 17:29
 */

namespace Manager;


class CarsManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('cars');
    }
    /*
     *
     */
    public function getCarsList()
    {
        $sql=('
        SELECT matricule,cb.name as brand,model.name as model,cars.id as id 
        FROM cars 
        INNER JOIN car_brand AS cb 
        ON cb.id=cars.id_car_brand 
        INNER JOIN model 
        ON  cars.car_model= model.id
        WHERE model.name != "non renseigné"
        ORDER BY cars.date_created DESC 
        ');
        $req=$this->dbh->query($sql);
        return $req->fetchAll();
    }

    /*
     * retourn la liste des clients en fonction de la recherche
     *
     * @param string $search
     * @return array $cars
     */
    public function getCarSearchList($search)
    {
        $req=$this->dbh->prepare('SELECT id FROM cars WHERE matricule LIKE :search');
        $req->execute(array('search' => $search.'%'));
        return $req->fetchAll();
    }

    /*
     * récupère la liste des modèles par rapport à la marque
     *
     * @param int $idBrand id de la marque selectionné
     * @return array $models list des modèles de la marque
     */
    public function getModelList($idBrand)
    {
        $req=$this->dbh->prepare('SELECT * FROM model WHERE id_brand = :idBrand ORDER BY name');
        $req->execute(array('idBrand' => $idBrand));
        return $req->fetchAll();
    }

    /*
     * récupère la liste des auto par rapport à un propriétaire
     *
     * @param int $idOwner id du propriétaire
     * @return array $cars liste des autos appartenant au propriétaire
     */
    public function getCarsListToOwner($idOwner)
    {
        $req=$this->dbh->prepare('SELECT c.matricule,c.id,m.name as name FROM cars as c INNER JOIN model as m ON c.car_model=m.id  WHERE c.id_owner = :idOwner');
        $req->execute(array('idOwner' => $idOwner));
        return $req->fetchAll();
    }
}