/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 03/10/16
 * Time: 22:06
 */
<?php $this->layout('layout', ['title' => 'Ajout nouveau modèle']) ?>

<?php $this->start('main_content') ?>
<form method="post" action="#">
    <div class="selectDivision">
    <select id="brandSelect" name="brand">
        <option value="no" class="selectDefault" <?php if(!empty($errors) && $choice['brand']=='no'){ echo 'selected'; }?> >Marque</option>
    <?php
        foreach ($brandList as $brand)
        {
            if($brand['id']!=32){
            ?>
            <option value="<?= $brand['id'] ?>" <?php if(!empty($errors) && $brand['id']==$choice['brand']){ echo 'selected'; }?>><?= $brand['name']?></option>
            <?php
             }
        }
    ?>
    </select>
    </div>
    <input type="text" name="model" placeholder="Modèle" value="<?php if(!empty($errors)){ echo $choice['model'];}?>" required/>
    <button type="submit" name="addModel" class="btn btn-success btn-small">Enregistrer la marque</button>
</form>
<?php
if(isset($_POST['addModel'])){
    if(empty($errors)){
        echo '<div class="alert-block"><p class="alert alert-success">Nouveau Modèle enregistré</p></div>';
    }else{
        foreach ($errors as $error){
            echo '<p class="alert alert-danger">'.$error.'</p>';
        }
    }

}
?>
<?php $this->stop('main_content') ?>
