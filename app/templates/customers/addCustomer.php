/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 11:09
 */
<?php $this->layout('layout', ['title' => 'Nouveau client']) ?>

<?php $this->start('main_content') ?>
    <form method="POST" action="#">
        <input type="text" placeholder="nom" name="lastname" value="<?php if(isset($customer) && !empty($errors)){echo $customer['lastname'];} ?>" required />
        <input type ="text" placeholder="prénom" name="firstname" value="<?php if(isset($customer) && !empty($errors)){echo $customer['firstname'];} ?>" required />
        <input type="text" placeholder="adresse" name="adress" value="<?php if(isset($customer) && !empty($errors)){echo $customer['adress'];} ?>"required/>
        <input type="text" placeholder="code postal" name="zipcode" value="<?php if(isset($customer) && !empty($errors)){echo $customer['zipcode'];} ?>" maxlength="5" required/>
        <div class="selectDivision">
            <select name="idCity" id="citySelect" required ></select>
        </diV>
        <!--<input type="text" placeholder="city" name="city" value="<?php if(isset($customer) && !empty($errors)){echo $customer['city'];} ?>" required />-->
        <input type="email" placeholder="email" name="email" value="<?php if(isset($customer) && !empty($errors)){echo $customer['email'];} ?>"/>
        <input type="tel" placeholder="téléphone" name="phone" value="<?php if(isset($customer) && !empty($errors)){echo $customer['phone'];} ?>" required/>
        <button type="submit" name="addCustomer" class="btn btn-success btn-small">Ajouter</button>
    </form>
    <?php
        if(empty($errors) && isset($customer)){
            ?><p class="alert alert-success">nouveau client ajouté</p><?php
        }else{
            foreach ($errors as $error => $post){
                ?>
                <p class="alert alert-danger"><?= $post ?></p>
                <?php
            }
        }
    ?>
<?php $this->stop('main_content') ?>