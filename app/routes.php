<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'home'],
        ['GET', '/clients', 'Clients#listing','listing_customers'],
        ['GET', '/clients/[i:id]', 'Clients#view','view_customer'],
        ['GET|POST', '/clients/edit/[i:id]', 'Clients#edit','edit_customer'],
        ['GET|POST', '/clients/add', 'Clients#add','add_customer'],
        ['GET', '/autos', 'Cars#listing','listing_cars'],
        ['GET', '/autos/[i:id]', 'Cars#view','view_car'],
        ['GET|POST', '/autos/edit/[i:id]', 'Cars#edit','edit_car'],
        ['GET|POST', '/autos/add', 'Cars#add','add_car'],
        ['GET', '/search', 'Ajax#customerSearch','ajax_customer_search'],
        ['GET', '/carsearch', 'Ajax#carSearch','ajax_car_search'],
        ['GET|POST', '/brandselect', 'Ajax#brandSelect','ajax_brand_select'],
        ['GET|POST', '/addBrand', 'Cars#addBrand','add_brand'],
        ['GET|POST', '/addModel', 'Cars#addModel','add_model'],
        ['GET|POST', '/nouvelle-facture', 'Bills#addBill','add_bill'],
        ['GET', '/ownerselect', 'Ajax#ownerSelect','ajax_owner_select'],
        ['GET', '/servicecategoryselect', 'Ajax#serviceCategorySelect','ajax_service_category_select'],
        ['GET', '/sizeselect', 'Ajax#sizeSelect','ajax_size_select'],
        ['GET', '/factures', 'Bills#listing','listing_bills'],
        ['GET|POST', '/facture/[i:id]', 'Bills#view','view_bill'],
        ['GET', '/billprint', 'Ajax#billPrint','ajax_print'],
        ['GET', '/billpay', 'Ajax#billPayement','ajax_payement'],
        ['GET', '/billgroup', 'Ajax#createBillsGroup','ajax_create_bill_group'],
        ['GET|POST', '/factureGroupe/[i:id]', 'Bills#viewBillGroup','view_bill_group'],
        ['GET', '/billgrouppay', 'Ajax#billGroupPayement','ajax_bill_group_payement'],
        ['GET', '/billsbillgrouppay', 'Ajax#billsOfBillGroupPayement','ajax_group_payement'],
        ['GET', '/billgroupprint', 'Ajax#billGroupPrint','ajax_bill_group_print'],
        ['GET', '/billotherservice', 'Ajax#listOtherService','ajax_other_service'],
        ['GET', '/citylist', 'Ajax#cityList','ajax_city_list'],
        ['GET', '/deletebill', 'Ajax#deletebill','ajax_delete_bill'],
	);