<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 17:27
 */

namespace Controller;

use \W\Controller\Controller;

class CarsController extends Controller
{
    private $carsManager;
    private $brandManager;
    private $modelManager;

    public function __construct(){
        $this->carsManager = new \Manager\CarsManager();
        $this->brandManager = new\Manager\BrandManager();
        $this->modelManager = new\Manager\ModelManager();
    }

    /*
     * récupère la liste des véhicules
     */
    public function listing()
    {
        $cars=$this->carsManager->getCarsList();
        $this->show('cars/cars', ['cars' => $cars]);
    }

    /*
     * formulaire d'ajout d'un véhicule
     */
    public function add()
    {
        /*récupération liste des marques*/
        $brandList=$this->brandManager->getBrands();
        /*récupération de la liste des clients*/
        $customersManager = new \Manager\CustomersManager();
        $ownerList = $customersManager->getCustomersList();
        $errors=[];
        $car=[];
        /*on test si le formulaire a été soumis*/
        if(isset($_POST['addCar'])){
            /*traitement données*/
            $matricule = trim(htmlspecialchars($_POST['matricule']));
            $idBrand=trim(htmlspecialchars($_POST['brand']));
            $idModel=trim(htmlspecialchars($_POST['model']));
            $idOwner=trim(htmlspecialchars($_POST['owner']));
            $car=['matricule'=>$matricule,'id_car_brand'=>$idBrand,'car_model'=>$idModel,'id_owner'=>$idOwner];
            /*vérification formulaire*/
            /*expression régulière à faire sur immat*/
            if($idBrand=="no"){
                $errors['brand']="veuillez choisir une marque";
            }
            if($idModel=="no"){
                $errors['model']="veuillez choisir un modèle";
            }
            if($idOwner=="no"){
                $errors['owner']="veuillez choisir un propriétaire";
            }

            /*insertion nouvel auto ou renvoi erreur*/
            if(empty($errors)){
                $this->carsManager->setTable('cars')->insert($car);
            }

        }

        $this->show('cars/addCar',['brandList'=>$brandList,'ownerList'=>$ownerList,'errors'=>$errors,'car'=>$car]);
    }

    /*affiche les infos du véhicule*/
    public function view($id)
    {
        $car=$this->carsManager->find($id);
        $this->show('cars/car',['car'=>$car]);
    }

    /*permet de modifier les donnees du véhicule*/
    public function edit($id)
    {
        $car=$this->carsManager->find($id);
        /*récupération liste des marques*/
        $brandList =$this->carsManager->setTable('car_brand')->findAll();
        /*récupération de la liste des clients*/
        $customersManager = new \Manager\CustomersManager();
        /*récupération de la liste des modèles de la marques*/
        $modelList = $this->carsManager->getModelList($car['id_car_brand']);
        /*récupération de la listes des propriétaires*/
        $ownerList = $customersManager->getCustomersList();
        if(isset($_POST['addCar'])) {
            $errors=[];
            /*traitement données*/
            $matricule = trim(htmlspecialchars($_POST['matricule']));
            $idBrand = trim(htmlspecialchars($_POST['brand']));
            $idModel = trim(htmlspecialchars($_POST['model']));
            $idOwner = trim(htmlspecialchars($_POST['owner']));
            $car = ['matricule' => $matricule, 'id_car_brand' => $idBrand, 'car_model' => $idModel, 'id_owner' => $idOwner];
            /*vérification formulaire*/
            /*expression régulière à faire sur immat*/
            if ($idBrand == "no") {
                $errors['brand'] = "veuillez choisir une marque";
            }
            if ($idModel == "no") {
                $errors['model'] = "veuillez choisir un modèle";
            }
            if ($idOwner == "no") {
                $errors['owner'] = "veuillez choisir un propriétaire";
            }

            /*insertion nouvel auto ou renvoi erreur*/
            if (empty($errors)) {
                $this->carsManager->setTable('cars')->update($car,$id);
            }
        }
        $this->show('cars/editCar',['car'=>$car,'brandList'=>$brandList,'ownerList'=>$ownerList,'modelList'=>$modelList,'errors'=>$errors]);
    }

    public function addBrand()
    {
        $errors=[];
        if(isset($_POST['addBrand'])){
            $brand = trim(htmlspecialchars($_POST['brand']));
            $brand = ucfirst(strtolower($brand));
            if(!$this->brandManager->brandExist($brand)){
                $this->brandManager->insert(['name'=>$brand]);
            }
        }
        $this->show('cars/addBrand',['errors'=>$errors]);
    }

    public function addModel()
    {
        /*récupération de la liste des marques */
        $brandList = $this->brandManager->getBrands();
        /*formulaire soumis ?--*/
        $errors =[];
        if(isset($_POST['addModel'])){
            $model = trim(htmlspecialchars($_POST['model']));
            $model = ucfirst(strtolower($model));
            $idBrand = trim(htmlspecialchars($_POST['brand']));
            if($idBrand =='no'){
                $errors['brand']='Veuillez sélectionner une marque';
            }
            if($this->modelManager->modelExist($model,$idBrand)){
                $errors['exist'] = 'Ce modèle a déja été enregistré';
            }
            if(empty($errors)){
                $this->modelManager->insert(['name'=>$model,'id_brand'=>$idBrand]);
            }else{
                $this->show('cars/addModel',['brandList'=>$brandList,'errors'=>$errors,'choice'=>['model'=>$model,'brand'=>$idBrand]]);
            }
        }
        $this->show('cars/addModel',['brandList'=>$brandList,'errors'=>$errors]);
    }
}