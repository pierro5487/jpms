<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 18:12
 */

namespace Controller;

use \W\Controller\Controller;

class AjaxController extends Controller
{
    private $billsGroupManager;
    private $billManager;
    private $billsGroupBillManager;
    private $otherServiceManager;
    private $cityManager;

    public function __construct()
    {
        $this->billsGroupManager = new\Manager\BillsGroupManager();
        $this->billManager = new \Manager\BillManager();
        $this->billsGroupBillManager = new\Manager\BillsGroupBillManager();

        $this->otherServiceManager = new\Manager\OtherServiceManager();
        $this->cityManager = new\Manager\CityManager();
    }
    /*
     * ajax pour la recherche sur la liste des clients
     */
    public function customerSearch()
    {
        $search = $_GET['search'];
        $customersManager = new \Manager\CustomersManager();
        $customersList=$customersManager->getCustomersSearchList($search);
        $this->showJson($customersList);
    }

    /*
    * ajax pour la recherche sur la liste des auto
    */
    public function carSearch()
    {
        $search = $_GET['search'];
        $carsManager = new \Manager\CarsManager();
        $carsList=$carsManager->getCarSearchList($search);
        $this->showJson($carsList);
    }

    /*
    * ajax pour l'ajout d'une nouvelle auto liste des modèle suivant la marque sélectionné
    */
    public function brandSelect()
    {
        $idBrand = $_GET['idBrand'];
        $carsManager = new \Manager\CarsManager();
        $modelList = $carsManager->getModelList($idBrand);
        $this->showJson($modelList);

    }

    /*
     * ajax liste les autos par rapport au propriétaire sélectionné
     */
    public function ownerSelect()
    {
        $idOwner = $_GET['idOwner'];
        $carsManager = new \Manager\CarsManager();
        $carsList = $carsManager->getCarsListToOwner($idOwner);
        $this->showJson($carsList);
    }

    /*
     * ajax renvoi la liste des categories de services
     */
    public function serviceCategorySelect()
    {
        $categoryManager = new \Manager\ServiceCategoryManager();
        $categoryList = $categoryManager->findAll();
        $this->showJson($categoryList);
    }

    /*
     * ajax renvoi la liste des services en fonction de la categorie selectionné
     */
    public function sizeSelect()
    {
        $size = $_GET['size'];
        $mountingManager = new \Manager\MountingManager();
        $servicesList = $mountingManager->getServicesListWithSize($size);
        $this->showJson($servicesList);
    }

    /*
     * ajoute un drapeau en db pour duplicata
     */
    public function billPrint()
    {
        $idBill = $_GET['idBill'];
        $billManager = new \Manager\BillManager();
        $billManager->update(['print'=>1],$idBill);
    }

    /*
     * ajoute un drapeau en db pour duplicata pour les facture groupé
     */
    public function billGroupPrint()
    {
        $idBill = $_GET['idBillGroup'];
        $this->billsGroupManager->update(['print'=>1],$idBill);
    }

    /*
     * ajoute le moyen de paiement dans la db
     */
    public function billPayement(){
        $idBill = $_GET['idBill'];
        $payement= $_GET['pay'];
        $billManager = new \Manager\BillManager();
        $billManager->update(['pay'=>$payement],$idBill);
    }

    public function createBillsGroup()
    {
        $idCustomer=$_GET['idCustomer'];
        /*on teste si le client a déja une facture groupé non payé*/
        $billGroupNoPay = $this->billsGroupManager->getBillGroupNoPayForCustomer($idCustomer);
        if($billGroupNoPay!=false){
            $idBillGroupNoPay =$billGroupNoPay['id'];
            /*si oui on efface avant de créé le nouveau*/
            /*on efface le billGroup*/
            $this->billsGroupManager->delete($idBillGroupNoPay);
            /*on efface les liens*/
            $this->billsGroupBillManager->deleteLink($idBillGroupNoPay);
        }
        /*récupération de la liste de facture non payé du client*/
        $bills = $this->billManager->getBillNoPayForCustomer($idCustomer);
        /*calcul du total*/
        $total=0;
        foreach ($bills as $bill){
            $total += $bill['total'];
        }
        /*insertion d'une nouvelle facture groupé*/
        $data = [
            'id_customer'=>$idCustomer,
            'total'=>$total
        ];
        $this->billsGroupManager->insert($data);
        $idBillGroup = $this->billsGroupManager->lastIdInsert();
        /* création des liens entre la facture groupé et les factures*/
        foreach ($bills as $bill){
            $data=[
                'id_bills_group'=>$idBillGroup,
                'id_bill'=>$bill['id']
            ];
            $this->billsGroupBillManager->insert($data);
        }
    }
    /*
    * ajoute le moyen de paiement pour les factures groupés dans la db
    */
    public function billsOfBillGroupPayement(){
        $idBill = $_GET['idBill'];
        $payement= $_GET['pay'];
        $billManager = new \Manager\BillManager();
        $billManager->update(['pay'=>$payement],$idBill);
    }

    /*
     * passe le payement de la facture groupé a true
     */
    public function billGroupPayement()
    {
        $idBill = $_GET['idBillGroup'];
        $this->billsGroupManager->update(['pay'=>true],$idBill);
    }

    public function listOtherService()
    {
        $otherServiceList = $this->otherServiceManager->findAll();
        $this->showJson($otherServiceList);
    }

    public function cityList()
    {
        $zipcode= $_GET['zipcode'];
        $cityList= $this->cityManager->getCityList($zipcode);
        $this->showJson($cityList);
    }

}