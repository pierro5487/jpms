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
 <button type="submit" name="addBrand">Enregistrer la marque</button>
</form>
<?php
if(isset($_POST['addModel'])){
 if(empty($errors)){
  echo '<p class="label-good">Nouvelle Marque enregistré</p>';
 }else{
  foreach ($errors as $error){
   echo '<p class="label-danger">'.$error.'</p>';
  }
 }

}
?>
<?php $this->stop('main_content') ?>
