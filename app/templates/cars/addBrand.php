/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 03/10/16
 * Time: 22:06
 */
<?php $this->layout('layout', ['title' => 'Ajout nouvelle marque']) ?>

<?php $this->start('main_content') ?>
<form method="post" action="#">
 <input type="text" name="brand" placeholder="Marque" required/>
 <button type="submit" name="addBrand" class="btn btn-success btn-small">Enregistrer la marque</button>
</form>
<?php
if(isset($_POST['addModel'])){
 if(empty($errors)){
  echo '<p class="alert alert-success">Nouvelle Marque enregistré</p>';
 }else{
  foreach ($errors as $error){
   echo '<p class="alert alert-danger">'.$error.'</p>';
  }
 }

}
?>
<?php $this->stop('main_content') ?>
