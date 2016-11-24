<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 11/10/16
 * Time: 20:31
 */
$recyclage=0;
?>
<?php $this->layout('layout', ['title' => 'facture FA'.$bill['id']]) ?>
<?php $this->start('main_content') ?>
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
        if(!$bill['print']){
            ?>
            <p>n°Facture: FA<?= $bill['id'];?></p>
            <?php
        }else{
            ?>
            <p>Duplicata Facture: FA<?= $bill['id'];?></p>
            <?php
        }
        ?>
        <p><?= $bill['date_created'];?></p>
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
                    <?= $bill['lastname'].' '.$bill['firstname'];?>
                </td>
                <td>
                    <?= $bill['adress'].' '.$bill['zipcode'].' '.$bill['city'];?>
                </td>
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
                    <td><?= $bill['brand']?></td>
                    <td><?= $bill['model']?></td>
                    <td><?= $bill['matricule']?></td>
                    <td><?= $bill['mileage']?></td>
                </tr>
            </table>
        </article>
    </div>
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
            foreach ($services as $service){
                ?>
                <tr>
                    <td>
                        <?php
                        if($service['switching']){
                            echo 'Permutation roue ';
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
                            if($service['position'] != 'no'){
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
            }
            if($recyclage!=0){
                ?>
                <tr>
                    <td>Recyclage Pneumatique</td>
                    <td><?= $recyclage ?></td>
                    <td>2</td>
                    <td><?= $recyclage*2?></td>
                </tr>
                <?php
            }
            foreach ($decalaminageServices as $dService){
                if($dService['quantity']!='0'){
                ?>
                <tr>
                    <td><?= $dService['description'] ?></td>
                    <td><?= $dService['quantity'] ?></td>
                    <td><?= $dService['price'] ?></td>
                    <td><?= $dService['price']*$dService['quantity'] ?></td>
                </tr>
                <?php
                }
            }
            foreach($otherServices as $otherService){
                ?>
                <tr>
                    <td><?= $otherService['name'] ?></td>
                    <td><?= $otherService['quantity'] ?></td>
                    <td><?= $otherService['price'] ?></td>
                    <td><?= $otherService['price']*$otherService['quantity'] ?></td>
                </tr>
                <?php
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="3">Total:</td>
                    <td><?= $bill['total'].'€' ?></td>
                </tr>
            </tfoot>
        </table>
        <p class="tvaMention">TVA non applicable - article 293 B du CGI</p>
    </article>
    </div>
    <?php
        if($bill['pay']=='null'){
        ?>
            <div id="takePayement">
                <select id="takePayementSelect">
                    <option value="es">En espèce</option>
                    <option value="cb">Par carte bancaire</option>
                    <option value="ch">Par chèque</option>
                </select>
                <button id="payConfirm">Confirmer le paiement</button>
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
                <td><?= $bill['total'].'€'?></td>
                <td>
                    <?php
                    if($bill['pay']=='cb'){
                        echo 'Réglé par carte bancaire';
                    }else if($bill['pay']=='ch'){
                        echo 'Réglé par chèque';
                    }else if($bill['pay']=='es'){
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
<?php
if($bill['information']!=''){
    ?>
    <table id="information">
        <tr>
            <th>Notes:</th>
        </tr>
        <tr>
            <td><?= $bill['information'] ?></td>
        </tr>
    </table>
    <?php
}
?>
<article>
    <?php
    if(!$bill['print']){
        ?>
            <button type="submit" id="print" class="printButton">imprimer</button>
        <?php
    }else{
        ?>
            <button type="submit" id="print" class="printButton">imprimer un duplicata</button>
            <div id="billDuplicata"><p>Duplicata</p></div>
        <?php
    }
    ?>
</article>
<?php $this->stop('main_content') ?>
