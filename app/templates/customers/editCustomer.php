/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 16:48
 */
<?php $this->layout('layout', ['title' => 'Modification fiche client']) ?>

<?php $this->start('main_content') ?>
    <form method="POST" action="#">
        <input type="text" placeholder="nom" name="lastname" value="<?php echo $customer['lastname']; ?>" required />
        <input type ="text" placeholder="prénom" name="firstname" value="<?php echo $customer['firstname']; ?>" required />
        <input type="text" placeholder="adresse" name="adress" value="<?php echo $customer['adress']; ?>"required/>
        <input type="text" placeholder="code postal" name="zipcode" value="<?php echo $customer['zipcode']; ?>" required/>
        <div class="selectDivision">
            <select name="idCity" id="citySelect" required >
                <?php
                foreach ($cityList as $city) {
                    ?>
                    <option value="<?=$city['id']?>" <?php if($city['id']==$customer['idCity']){ echo 'selected';}?>><?=$city['VILLE'] ?></option>
                    <?php
                }
                ?>
            </select>
        </diV>
        <input type="email" placeholder="email" name="email" value="<?php echo $customer['email'];?>"/>
        <input type="tel" placeholder="téléphone" name="phone" value="<?php echo $customer['phone']; ?>" required/>
        <button type="submit" name="editCustomer">Ajouter</button>
    </form>
    <?php
        if(isset($_POST['editCustomer'])){
             if(empty($errors) && isset($customer)){
            ?><p>client mis à jour</p><?php
            }else{
                foreach ($errors as $error => $post){
                    ?>
                    <p class="label label-danger"><?= $post ?></p>
                    <?php
                }
            }
        }
    ?>
<?php $this->stop('main_content') ?>