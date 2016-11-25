<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 11/10/16
 * Time: 20:31
 */
$recyclage=0;
?>
<?php $this->layout('layout', ['title' => 'facture FC'.$billGroup['id']]) ?>
<?php $this->start('main_content') ?>
<div id="BillGroupView">
<div id="billHead">
    <img id="logo" src="<?= $this->assetUrl('img/logo.png') ?>""/>
    <article id="billAdress">
        <p>Jp Multi service</p>
        <p>27 rue ambroize croizat</p>
        <p>54490 Piennes</p>
        <p>09 71 55 20 63</p>
        <p>blaise.jean-pierre@wanadoo.fr</p>
        <p>SIRET : 512 946 591 000 17</p>
    </article>
    <article id="billInfo">
        <?php
        if(!$billGroup['print']){
            ?>
            <p>n°Facture: FC<?= $billGroup['id'];?></p>
            <?php
        }else{
            ?>
            <p>Duplicata Facture: FC<?= $billGroup['id'];?></p>
            <?php
        }
        ?>
        <p><?= $billGroup['date_created'];?></p>
    </article>
</div>
<div id="billContain">
    <div id="billCustomerInfo">
        <article id="billCustomer">
            <table>
                <tr>
                    <th>Client</th>
                    <th>Adresse</th>
                </tr>
                <td>
                    <?= $billGroup['lastname'].' '.$billGroup['firstname'];?>
                </td>
                <td>
                    <?= $billGroup['adress'].' '.$billGroup['zipcode'].' '.$billGroup['city'];?>
                </td>
            </table>
        </article>
    </div>
    <?php
    foreach($billGroupItems as $billGroupItem){

    ?>
    <div id="billGroupList">
        <article id="BillGroupItemDate">
            <table>
                <tr>
                    <th>Date</th>
                </tr>
                <tr>
                    <td><?= $billGroupItem['date_created']?></td>
                    <td class="idBillClass" style="display: none;"><?= $billGroupItem['id']?></td>
                </tr>
            </table>
        </article>
        <article id="billCar">
            <table>
                <tr>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Immatriculation</th>
                    <th>Kilométrage</th>
                </tr>
                <tr>
                    <td><?= $billGroupItem['brand']?></td>
                    <td><?= $billGroupItem['model']?></td>
                    <td><?= $billGroupItem['matricule']?></td>
                    <td><?= $billGroupItem['mileage']?></td>
                </tr>
            </table>
        </article>
        <div id="billServicesList">
            <article>
                <table>
                    <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <?php
                    foreach ($billGroupItem['services'] as $service){
                        ?>
                        <tr>
                            <td>
                                <?php
                                if($service['switching']){
                                    echo 'Permutation roue';
                                }else if($service['puncture_av']){
                                    echo 'Crevaison/pause champignon';
                                }else if($service['puncture_av']){
                                    echo 'Crevaison/pause mèche';
                                }else{
                                    if($service['mounting']){
                                        echo 'Montage ';
                                    }
                                    if($service['balancing']){
                                        echo 'Equilibrage ';
                                    }
                                    if($service['valve']){
                                        echo 'Valve ';
                                    }
                                    if($service['alu']){
                                        echo 'Aluminium ';
                                    }else{
                                        echo 'Tôle ';
                                    }
                                    if($service['mounting'] && $service['balancing']){
                                        echo $service['size'].'"';
                                    }
                                    if($service['truck']){
                                        echo ' Camionnette ';
                                    }
                                    if($service['runflat']){
                                        echo ' Taille basse ';
                                    }
                                    if($service['position']!='no'){
                                        echo $service['position'];
                                    }
                                    if($service['recyclage']){
                                        $recyclage +=$service['quantity'];
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $service['quantity'] ?></td>
                            <td><?= $service['price'] ?></td>
                            <td><?= $service['price']*$service['quantity'] ?></td>
                        </tr>
                        <?php
                        if($recyclage!=0 && $service['recyclage']){
                            ?>
                            <tr>
                                <td>Recyclage Pneumatique</td>
                                <td><?= $recyclage ?></td>
                                <td>2</td>
                                <td><?= $recyclage*2?></td>
                            </tr>
                            <?php
                        }
                    }
                    foreach ($billGroupItem['dservices'] as $dService){
                        if($dService['quantity']!='0') {
                            ?>
                            <tr>
                                <td><?= $dService['description'] ?></td>
                                <td><?= $dService['quantity'] ?></td>
                                <td><?= $dService['price'] ?></td>
                                <td><?= $dService['price'] * $dService['quantity'] ?></td>
                            </tr>
                            <?php
                        }
                    }
                    foreach ($billGroupItem['otherServices'] as $otherService){
                            ?>
                            <tr>
                                <td><?= $otherService['name'] ?></td>
                                <td><?= $otherService['quantity'] ?></td>
                                <td><?= $otherService['price'] ?></td>
                                <td><?= $otherService['price'] * $otherService['quantity'] ?></td>
                            </tr>
                            <?php
                    }
                    ?>
                    <tfoot>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td><?= $billGroupItem['total'].'€' ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php
                if($billGroupItem['information']!=''){
                    ?>
                    <table id="information">
                        <tr>
                            <th>Notes:</th>
                        </tr>
                        <tr>
                            <td><?= $billGroupItem['information'] ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </article>
        </div>
    </div>
    <?php
    }
    ?>
    <p class="tvaMention">TVA non applicable - article 293 B du CGI</p>
    <?php
    if($billGroup['pay']=='0'){
        ?>
        <div id="takePayement">
            <select id="takePayementSelect">
                <option value="es">En espèce</option>
                <option value="cb">Par carte bancaire</option>
                <option value="ch">Par chèque</option>
            </select>
            <button id="BillGroupPayConfirm">Confirmer le paiement</button>
        </div>
        <?php
    }
    ?>
    <div id="billPayement">
        <table>
            <tr>
                <th>Total</th>
                <th>Moyen de paiement</th>
            </tr>
            <tr>
                <td><?= $billGroup['total'].'€'?></td>
                <td>
                    <?php
                    if($billGroup['pay']=='cb'){
                        echo 'Réglé par carte bancaire';
                    }else if($billGroup['pay']=='ch'){
                        echo 'Réglé par chèque';
                    }else if($billGroup['pay']=='es'){
                        echo 'Réglé en espèce';
                    }else{
                        echo 'A régler';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div id="warning">
        <p>Veuillez verifier ou faire vérifier le serrage de vos roues après 30Km.</p>
    </div>
</div>
<article>
    <?php
    if(!$billGroup['print']){
        ?>
        <button type="submit" id="printBillGroup" class="printButton">imprimer</button>
        <?php
    }else{
        ?>
        <button type="submit" id="printBillGroup" class="printButton">imprimer un duplicata</button>
        <div id="billDuplicata"><p>Duplicata</p></div>
        <?php
    }
    ?>
</article>
</div>
<?php $this->stop('main_content') ?>
