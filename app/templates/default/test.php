<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 13/10/16
 * Time: 10:56
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CONSELIO</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
    $(function() {
        $('#myTab').tab();
    });
		</script>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">CONSELIO</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="#">Accueil</a></li>
						<li><a href="#">Créer un projet</a></li>
						<li class="active"><a href="#">Créer une tâche</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Contact</a></li>
					</ul>
        		</div>
        	</div>
        </div>

        <div class="container">
        	<div class="panel panel-info">
        		<div class="panel-heading">
    				<h3 class="panel-title">Création d'une tâche</h3>
    			</div>
  				<div class="panel-body">
  					<form class="form-horizontal" role="form" method="POST" action="#">
	        			<div class="form-group">
	        				<label for="Libelle" class="col-sm-2 control-label">Libelle</label>
	        				<div class="col-sm-10">
	        					<input type="text" class="form-control" id="Libelle" name="Libelle" />
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				<label for="Date" class="col-sm-2 control-label">Date exécution</label>
	        				<div class="col-sm-10">
	        					<input type="text" class="form-control" id="Date" name="Date" />
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				<label for="Client" class="col-sm-2 control-label">Client</label>
	        				<div class="col-sm-10">
	        					<select name="Client" id="Client" class="form-control">
	        						<option value="DEV01">AGNES Jérémy</option>
	        						<option value="DEV02">MAIRE Johann</option>
	        						<option value="DEV03">MANNE Antoine</option>
	        						<option value="DEV04">MULLER Camille</option>
	        						<option value="DEV05">QUENDERA Stéphane</option>
	        					</select>
	        				</div>
	        			</div>
	        			<div class="form-group">
		        			<div class="col-sm-10 col-sm-offset-2">
		        				<ul class="nav nav-tabs" role="tablist" id="myTab">
		        					<li class="active"><a href="#Type1" role="tab" data-toggle="tab">Type 1</a></li>
		        					<li><a href="#Type2" role="tab" data-toggle="tab">Type 2</a></li>
		        				</ul>
		        				<div class="tab-content">
		        					<div class="tab-pane active" id="Type1">
		        						<div class="col-sm-6">
				        					<div class="panel panel-success">
				        						<div class="panel-heading">
								    				<h3 class="panel-title">Liste des projets</h3>
								    			</div>
								    			<div class="panel-body">
								    				<div class="checkbox">
								    					<label>
								    						<input type="checkbox" name="" value="ON" /> Apply Intervention
								    					</label>
								    				</div>
								    				<div class="checkbox">
								    					<label>
								    						<input type="checkbox" name="" value="ON" checked="checked" /> Plateforme emailing
								    					</label>
								    				</div>
								    				<div class="checkbox">
								    					<label>
								    						<input type="checkbox" name="" value="ON" /> Site web agence immobilière
								    					</label>
								    				</div>
								    			</div>
				        					</div>
				        				</div>
				        				<div class="col-sm-6">
				        					<div class="panel panel-success">
				        						<div class="panel-heading">
								    				<h3 class="panel-title">Projets sélectionnés</h3>
								    			</div>
								    			<div class="panel-body">
								    				<ul>
								    					<li>Plateforme emailing</li>
								    				</ul>
								    			</div>
				        					</div>
				        				</div>
		        					</div>
		        					<div class="tab-pane" id="Type2">
		        						<div class="col-sm-5">
				        					<div class="panel panel-success">
				        						<div class="panel-heading">
								    				<h3 class="panel-title">Liste des projets</h3>
								    			</div>
								    			<div class="panel-body">
									    			<div class="list-group">
									    				<a href="#" class="list-group-item active">Apply Intervention</a>
									    				<a href="#" class="list-group-item">Plateforme emailing</a>
									    				<a href="#" class="list-group-item">Site web agence immobilière</a>
									    			</div>
								    			</div>
				        					</div>
				        				</div>
				        				<div class="col-sm-2 text-center">
				        					<div class="row" style="margin-top:54px;">
				        						<button class="btn btn-info"><i class="glyphicon glyphicon-forward"></i></button>
				        					</div>
				        					<div class="row">
				        						<button class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i></button>
				        					</div>
				        				</div>
				        				<div class="col-sm-5">
				        					<div class="panel panel-success">
				        						<div class="panel-heading">
								    				<h3 class="panel-title">Projets sélectionnés</h3>
								    			</div>
								    			<div class="panel-body">
								    				<div class="list-group">
									    				<a href="#" class="list-group-item">Plateforme emailing</a>
									    			</div>
								    			</div>
				        					</div>
				        				</div>
		        					</div>
		        				</div>
		        			</div>
	        			</div>
	        			<div class="form-group">
	        				<label for="Date" class="col-sm-2 control-label">Statut</label>
	        				<div class="col-sm-10">
	        					<div class="radio">
			    					<label class="label-checkbox">
			    						<input type="radio" name="Statut" value="ON" checked="checked" /> <span class="label label-danger">A faire</span>
			    					</label>
			    					<label class="label-checkbox">
			    						<input type="radio" name="Statut" value="ON" /> <span class="label label-warning">En cours</span>
			    					</label>
			    					<label class="label-checkbox">
			    						<input type="radio" name="Statut" value="ON" /> <span class="label label-info">Résolu</span>
			    					</label>
			    					<label class="label-checkbox">
			    						<input type="radio" name="Statut" value="ON" /> <span class="label label-success">Livré</span>
			    					</label>
			    				</div>
	        				</div>
	        			</div><br/>
	        			<div class="form-group">
	        				<div class="col-sm-offset-2 col-sm-10">
	        					<button type="submit" class="btn btn-success">
	        						<i class="glyphicon glyphicon-hand-right"></i>&nbsp;&nbsp;Enregistrer
	        					</button>
	        				</div>
	        			</div>
	        		</form>
  				</div>
  			</div>
        </div>
	</body>
</html>
