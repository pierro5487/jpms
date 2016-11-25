/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 03/10/16
 * Time: 21:01
 */
<?php $this->layout('layout', ['title' => 'Modification fiche véhicule']) ?>

<?php $this->start('main_content') ?>
<form method="POST" action="#">
    <label>N°Immatriculation</label>
    <input type="text" placeholder="immatriculation" name="matricule" value="<?php if(isset($car) && !empty($errors)){echo $car['lastname'];}else{echo $car['matricule'];} ?>" required />
    <div class="selectDivision">
        <select name="brand" id="brandSelect">
            <option class="selectDefault" value="no">Marque</option>
            <?php
            foreach($brandList as $brand){
                ?>
                <option value="<?= $brand['id'] ?>"<?php if($brand['id']==$car['id_car_brand']){echo 'selected';} ?>><?php echo $brand['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?= $this->url('add_brand')?>">Ajouter une marque de véhicule</a>
    </div>
    <div class="selectDivision">
        <select name="model" id="modelSelect" >
            <option class="selectDefault" value="no">Modèle</option>
            <?php
                foreach ($modelList as $model){
                    echo '<option value="'.$model['id'].'"';
                    if($model['id']==$car['car_model']){
                        echo 'selected';
                    }
                    echo '>'.$model['name'];
                    echo '</option>';
                }
            ?>
        </select>
        <a href="<?= $this->url('add_model')?>">Ajouter un modèle de véhicule</a>
    </div>
    <div class="selectDivision">
        <select name="owner">
            <option class="selectDefault" value="no">Propriétaire</option>
            <?php
            foreach($ownerList as $owner){
                ?>
                <option class="selectDefault" value="<?= $owner['id'] ?>"<?php if($owner['id']==$car['id_owner']){echo 'selected';}?>><?php echo $owner['lastname'].' '.$owner['firstname'] ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?= $this->url('add_customer')?>">Ajouter un client</a>
    </div>
    <button type="submit" name="addCar">Ajouter</button>
</form>
<?php
if(isset($errors) && empty($errors) && isset($car)){
    ?><p>auto mis à jour</p><?php
}else{
    foreach ($errors as $error => $post){
        ?>
        <p class="label label-danger"><?= $post ?></p>
        <?php
    }
}
?>
<?php $this->stop('main_content') ?>