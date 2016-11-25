<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 07/10/16
 * Time: 17:32
 */

namespace Controller;

use \W\Controller\Controller;

class BillsController extends Controller
{
    private $billManager;
    private $billServicesManager;
    private $billGroupManager;
    private $billsGroupBillManager;
    private $billDecalaminageManager;
    private $billOtherServiceManager;
    private $persoServiceManager;

    public function __construct()
    {
        $this->billManager= new \Manager\BillManager();
        $this->billServicesManager= new \Manager\BillServiceManager();
        $this->billGroupManager = new\Manager\BillsGroupManager();
        $this->billsGroupBillManager = new\Manager\BillsGroupBillManager();
        $this->billDecalaminageManager = new\Manager\BillDecalaminageManager();
        $this->billOtherServiceManager = new\Manager\BillOtherServiceManager();
        $this->persoServiceManager = new\Manager\PersoServiceManager();
    }

    public function addBill()
    {
        /*récupération de la liste des clients */
        $customersManager = new\Manager\CustomersManager();
        $customers=$customersManager->getCustomersList();
        /*----test soumission de formulaire*/
        if(isset($_POST['sendBill'])){
            $idCustomer=trim(htmlspecialchars($_POST['customer']));
            $idCar=trim(htmlspecialchars($_POST['car']));
            $mileage=trim(htmlspecialchars($_POST['mileage']));
            $information =trim(htmlspecialchars($_POST['information']));
            $services=trim(htmlspecialchars($_POST['services']));
            $total=trim(htmlspecialchars($_POST['total']));
            $dMotorServices=trim(htmlspecialchars($_POST['dMotorServices']));
            $otherServices =trim(htmlspecialchars($_POST['otherServices']));
            $persoServices =trim(htmlspecialchars($_POST['persoServices']));
            /*verification*//*on ne verifie pas ce qui est reçu (modif html /utilisation en local) c'est pas bien!!!!*/
            /*vérification est faite avec javascript */

            /*on créé tout d'abord la facture */
            $data=['id_customer'=>$idCustomer,'id_car'=>$idCar,'mileage'=>$mileage,'total'=>$total,'information'=>$information];
            $this->billManager->insert($data);
            $idBill=$this->billManager->lastIdInsert();
            

            /*on ajoute les sercices montages correspondant à la facture*/
            $services = explode(';',$services);
            for($i=0;$i < (count($services)-1);$i++){
                $service=explode(',',$services[$i]);
                $idService=$service[0];
                $quantity=$service[1];
                $position=$service[2];
                $recyclage=$service[3];
                $this->billServicesManager->insert(['id_mounting'=>$idService,'id_bill'=>$idBill,'quantity'=>$quantity,'position'=>$position,'recyclage'=>$recyclage]);
            }
            /*on ajoute les services décalaminage*/
            if($dMotorServices !=0){
                $idDecalaminage = 1;
                $this->billDecalaminageManager->insert(['id_bill'=>$idBill,'id_decalaminage'=>$idDecalaminage,'quantity'=>$dMotorServices]);
            }

            /*on ajoute les autres services*/
            $services = explode(';',$otherServices);
            for($i=0;$i < (count($services)-1);$i++){
                $service=explode(',',$services[$i]);
                $idOtherService=$service[0];
                $quantity=$service[1];
                $this->billOtherServiceManager->insert(['id_bill'=>$idBill,'id_other_service'=>$idOtherService,'quantity'=>$quantity]);
            }
            /*on ajoute les services perso*/
            $services = explode(';',$persoServices);
            for($i=0;$i < (count($services)-1);$i++){
                $service=explode(',',$services[$i]);
                $persoServiceName=$service[0];
                $quantity=$service[1];
                $price=$service[2];
                $this->persoServiceManager->insert(['id_bill'=>$idBill,'name'=>$persoServiceName,'quantity'=>$quantity,'price'=>$price]);
            }

            $this->redirectToRoute('view_bill', ['id' => $idBill]);
        }

        $this->show('bills/addBill', ['customers'=>$customers]);
    }

    public function listing()
    {
        /*récupération de la liste des factures*/
        $bills = $this->billManager->getBillForListing();
        $this->show('bills/bills',['bills'=>$bills]);
    }

    public function view($id)
    {
        /*récupération de toutes les données de la facture */
        $bill=$this->billManager->getBill($id);
        /* récupération des services montage facturés */
        $services = $this->billServicesManager->getMountingServicesForBill($id);
        /* récupération des services decalaminage */
        $decalaminageServices = $this->billDecalaminageManager->getDecalaminageServicesForBill($id);
        /*récupération des autres services*/
        $otherServices = $this->billOtherServiceManager->getOtherServices($id);

        $this->show('bills/bill',['bill'=>$bill,'services'=>$services,'decalaminageServices'=>$decalaminageServices,'otherServices'=>$otherServices]);
    }

    public function viewBillGroup($id)
    {
        /*on récupère donnée de la facture*/
        $billGroup=$this->billGroupManager->getBillGroupInfo($id);
        /*------------------------------*/
        $billGroupList=$this->billsGroupBillManager->getBillGroupListInfo($id);
        $billGroupItems=[];
        foreach ($billGroupList as $bill){
            $services = $this->billServicesManager->getMountingServicesForBill($bill['id_bill']);
            $dServices = $this->billDecalaminageManager->getDecalaminageServicesForBill($bill['id_bill']);
            /*récupération des autres services*/
            $otherServices = $this->billOtherServiceManager->getOtherServices($bill['id_bill']);
            $billInfo=[
                'id'=>$bill['id_bill'],
                'mileage'=>$bill['mileage'],
                'total'=>$bill['total'],
                'date_created'=>$bill['date_created'],
                'matricule'=>$bill['matricule'],
                'brand'=>$bill['brand'],
                'model'=>$bill['model'],
                'information'=>$bill['information'],
                'services'=>$services,
                'dservices'=>$dServices,
                'otherServices'=>$otherServices,
            ];
            array_push($billGroupItems,$billInfo);
        }
        $this->show('bills/billGroup',['billGroup'=>$billGroup,'billGroupItems'=>$billGroupItems]);
    }
}