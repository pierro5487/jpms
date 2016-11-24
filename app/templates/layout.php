<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>

	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" defer></script>
    <script>
        var ajaxCustomerSearch= '<?= $this->url('ajax_customer_search') ?>';
		var ajaxCarSearch= '<?= $this->url('ajax_car_search') ?>';
		var ajaxBrandSelect= '<?= $this->url('ajax_brand_select') ?>';
		var ajaxOwnerSelect= '<?= $this->url('ajax_owner_select') ?>';
		var ajaxServiceCategorySelect= '<?= $this->url('ajax_service_category_select') ?>';
		var ajaxSizeSelect= '<?= $this->url('ajax_size_select') ?>';
		var ajaxNumberPrinting= '<?= $this->url('ajax_print') ?>';
		var ajaxPayement= '<?= $this->url('ajax_payement') ?>';
		var ajaxCreateBillsGroup= '<?= $this->url('ajax_create_bill_group') ?>';
		var ajaxGroupPayement= '<?= $this->url('ajax_group_payement') ?>';
		var ajaxBillGroupPayement= '<?= $this->url('ajax_bill_group_payement') ?>';
        var ajaxBillGroupNumberPrinting= '<?= $this->url('ajax_bill_group_print') ?>';
        var ajaxOthersService= '<?= $this->url('ajax_other_service') ?>';
        var ajaxCityList=  '<?= $this->url('ajax_city_list') ?>';
    </script>
    <script src="<?= $this->assetUrl('js/script.js') ?>" defer></script>

</head>
<body>
	<div class="container">
		<header>
			<header>
				<h1><?= $this->e($title) ?></h1>
			</header>
            <nav>
				<ul class="menu-primaire">
					<li class="menu-liste-primaire">
						<div>
							Clients
						</div>
						<ul class="menu-secondaire">
							<li class="menu-liste-secondaire"><a href="<?= $this->url('listing_customers')?>">Liste de clients</a></li>
							<li class="menu-liste-secondaire"><a href="<?= $this->url('add_customer')?>">Nouveau client</a></li>
						</ul>
					</li>
					<li class="menu-liste-primaire">
                        <div>
                            Autos
                        </div>
						<ul class="menu-secondaire">
							<li class="menu-liste-secondaire"><a href="<?= $this->url('listing_cars')?>">Liste d'autos</a></li>
							<li class="menu-liste-secondaire"><a href="<?= $this->url('add_car')?>">Nouvelle auto</a></li>
							<li class="menu-liste-secondaire"><a href="<?= $this->url('add_brand')?>">Ajouter une marque</a></li>
							<li class="menu-liste-secondaire"><a href="<?= $this->url('add_model')?>">Ajouter un modèle</a></li>
						</ul>
					</li>
					<li class="menu-liste-primaire">
                        <div>
                            Factures
                        </div>
						<ul class="menu-secondaire">
							<li class="menu-liste-secondaire"><a href="<?= $this->url('add_bill')?>">Nouvelle Facture</a></li>
							<li class="menu-liste-secondaire"><a href="<?= $this->url('listing_bills')?>">liste des factures</a></li>
						</ul>
					</li>
				</ul>
            </nav>
		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	</div>
</body>
</html>