<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 07/10/16
 * Time: 17:34
 */
?>
<?php $this->layout('layout', ['title' => 'Nouvelle facture']) ?>
<?php $this->start('main_content') ?>
<form id="BillForm" method="post" action="#">
    <div class="selectDivision">
        <select id="ownerSelectForBill"name="customer">
            <option class="selectDefault" value="no">Propriétaire</option>
            <?php
            foreach ($customers as $customer){
                ?>
                <option value="<?=$customer['id'] ?>"><?=$customer['lastname'].' '.$customer['firstname'] ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?= $this->url('add_customer')?>">Ajouter un client</a>
    </div>
    <div class="selectDivision">
        <select id="carsSelectForBill" name="car">
            <option class="selectDefault" value="no">Auto</option>
            <option value="0">Non renseigné</option>
        </select>
        <a href="<?= $this->url('add_car')?>">Ajouter un vehicule</a>
    </div>
    <input type="text" name="mileage" placeholder="Kilometrage" required/>
    <input type="hidden" name="services" value=""/>
    <input type="hidden" name="dMotorServices" value="0"/>
    <input type="hidden" name="otherServices" value=""/>
    <input type="hidden" name="total" value="0"/>
    <input type="hidden" name="persoServices" value=""/>
    <textarea placeholder="Notes" name="information" maxlength="250"></textarea>
    <div id="servicesTable">
        <button type="button" id="addServiceForBill">Ajouter un service</button>
        <table>
            <thead
            <tr>
                <th>Designation</th>
                <th>Quantité</th>
                <th>prix</th>
                <th>total</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">Total:</td>
                <td>0</td>
            </tr>
            </tfoot>
        </table>
        <button type="button" id="resetTable">Effacer la liste</button>
    </div>
    <p><button type="submit" name="sendBill">Enregistrer la facture</button></p>
</form>

<?php $this->stop('main_content') ?>
