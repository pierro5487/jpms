/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 02/10/16
 * Time: 19:21
 */
<?php $this->layout('layout', ['title' => 'Ajout d\'un véhicule']) ?>

<?php $this->start('main_content') ?>
<form method="POST" action="#">
    <label>N°Immatriculation</label>
    <input type="text" placeholder="immatriculation" name="matricule" value="<?php if(isset($car) && !empty($errors)){echo $car['lastname'];} ?>" required />
    <div class="selectDivision">
        <select name="brand" id="brandSelect">
            <option class="selectDefault" value="no">Marque</option>
            <?php
                foreach($brandList as $brand){
                    if($brand['id']!=32){
                    ?>
                        <option value="<?= $brand['id'] ?>"><?php echo $brand['name'];?></option>
                    <?php
                    }
                }
            ?>
        </select>
        <a href="<?= $this->url('add_brand')?>">Ajouter une marque de véhicule</a>
    </div>
    <div class="selectDivision">
        <select name="model" id="modelSelect" >
            <option class="selectDefault" value="no">Modèle</option>
        </select>
        <a href="<?= $this->url('add_model')?>">Ajouter un modèle de véhicule</a>
    </div>
    <div class="selectDivision">
        <select name="owner">
            <option class="selectDefault" value="no">Propriétaire</option>
            <?php
            foreach($ownerList as $owner){
                ?>
                <option value="<?= $owner['id'] ?>"><?php echo $owner['lastname'].' '.$owner['firstname'] ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?= $this->url('add_customer')?>">Ajouter un client</a>
    </div>
    <button type="submit" name="addCar">Ajouter</button>
</form>
<?php
if(empty($errors) && isset($car)){
    ?><p class="label-good">nouvel auto ajouté</p><?php
}else{
    foreach ($errors as $error => $post){
        ?>
        <p class="label-danger"><?= $post ?></p>
        <?php
    }
}
?>
<?php $this->stop('main_content') ?>