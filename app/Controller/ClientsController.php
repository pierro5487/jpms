<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 30/09/16
 * Time: 17:59
 */

namespace Controller;

use \W\Controller\Controller;

class ClientsController extends Controller
{
    private $customersManager;
    private $billsManager;
    private $billsGroupManager;
    private $cityManager;

    public function __construct()
    {
        $this->customersManager = new \Manager\CustomersManager();
        $this->billsManager = new \Manager\BillManager();
        $this->billsGroupManager = new\Manager\BillsGroupManager();
        $this->cityManager = new\Manager\CityManager();
    }

    /*
     * page de listing clients
     */
    public function listing()
    {
        /*$customersManager = new \Manager\CustomersManager();*/
        $customers=$this->customersManager->getCustomersList();
        $this->show('customers/customers', ['customers' => $customers]);
    }

    /*
     * voir une fiche client
     *
     * @param int $id id-client
     * @return affiche les données du clients
     */
    public function view($id)
    {
        $customer=$this->customersManager->getCustomer($id);
        /* on récupère la liste des factures de ce client */
        $billList=$this->billsManager->getBillsForCustomers($id);
        /*on récupère la liste des factures cumulés */
        $billsGroupList=$this->billsGroupManager->getListBillsGroupForCustomer($id);
        $this->show('customers/customer',['customer'=>$customer,'bills'=>$billList,'billsGroup'=>$billsGroupList]);
    }

    /*
     * editer une fiche client
     * @param int $id id-client
     * @return formulaire avec champs préremplis
     */
    public function edit($id)
    {
        /*récupération des données client*/
        $customer=$this->customersManager->getCustomer($id);
        $cityList= $this->cityManager->getCityList($customer['zipcode']);
        if(isset($_POST['editCustomer'])){
            /*traitement données formulaire*/
            $lastname=trim(htmlspecialchars($_POST['lastname']));
            $firstname=trim(htmlspecialchars($_POST['firstname']));
            $adress=trim(htmlspecialchars($_POST['adress']));
            $idCity=trim(htmlspecialchars($_POST['idCity']));
            $email=trim(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));
            $phone=trim(htmlspecialchars($_POST['phone']));
            $newCustomer=[
                'lastname' => strtoupper($lastname),
                'firstname'=> ucfirst(strtolower($firstname)),
                'adress'   => $adress,
                'id_city'   => $idCity,
                'email'    => $email,
                'phone'    => $phone

            ];
            /*vérification données*/
            $errors = $this->validedCustomer($newCustomer);
            /*on teste si il y a des erreurs*/
            if(count($errors) == 0){
                $this->customersManager->update($newCustomer,$id);
                $this->redirectToRoute('listing_customers');
            }
            $this->show('customers/editCustomer',['errors'=>$errors,'customer'=>$newCustomer,'cityList'=>$cityList]);
        }
        $this->show('customers/editCustomer',['customer'=>$customer,'cityList'=>$cityList]);
    }

    /*
     * ajout d'un client
     */
    public function add()
    {
        $errors=[];
        if(isset($_POST['addCustomer'])){
            /*traitement données formulaire*/
            $lastname=trim(htmlspecialchars($_POST['lastname']));
            $firstname=trim(htmlspecialchars($_POST['firstname']));
            $adress=trim(htmlspecialchars($_POST['adress']));
            $idCity=trim(htmlspecialchars($_POST['idCity']));
            $email=trim(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));
            $phone=trim(htmlspecialchars($_POST['phone']));
            $newCustomer=[
                'lastname' => strtoupper($lastname),
                'firstname'=> ucfirst(strtolower($firstname)),
                'adress'   => $adress,
                'id_city'   => $idCity,
                'email'    => $email,
                'phone'    => $phone

            ];
            /*vérification données*/
            $errors = $this->validedCustomer($newCustomer);
            /*--verif doublon---*/
            if($this->customersManager->customerExist($newCustomer)){
                $errors['exist'] = 'Ce client existe déja';
            }
            /*on teste si il y a des erreurs*/
            if(count($errors) == 0){
                $this->customersManager->insert($newCustomer);
            }
            $this->show('customers/addCustomer',['errors'=>$errors,'customer'=>$newCustomer]);
        }
        $this->show('customers/addCustomer',['errors'=>$errors]);
    }

    /*
     * validation des données reçu
     * @param array $newCustomer données client
     * @return array $error erreurs
     */
    public function validedCustomer($customer)
    {
        $errors=[];
        if(!is_numeric($customer['phone']) || strlen($customer['phone'])!= 10){
            $errors['phone']="veuillez entrer un numéro de téléphone valide";
        }
        return $errors;
    }
}