/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 10:53
 */
<?php $this->layout('layout', ['title' => 'Fiche client']) ?>

<?php $this->start('main_content') ?>
<div id="customerContain">
    <article>
        <p id="idCustomer" style="display:none"><?=$customer['id'] ?></p>
        <p>Nom : <?=$customer['lastname'] ?></p>
        <p>Prénom : <?=$customer['firstname'] ?></p>
        <p>Adresse : <?=$customer['adress'].' '.$customer['zipcode'].' '.$customer['city'] ?></p>
        <p>Email : <?=$customer['email'] ?></p>
        <p>Enregistré le : <?=$customer['date_created'] ?></p>
        <p>Téléphone: <?=$customer['phone'][0].$customer['phone'][1].'.'.$customer['phone'][2].$customer['phone'][3].'.'.$customer['phone'][4].$customer['phone'][5].'.'.$customer['phone'][6].$customer['phone'][7].'.'.$customer['phone'][8].$customer['phone'][9] ?></p>
    </article>
    <article>
        <table>
            <tr>
                <th>n°Facture</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        <?php
        $notPaye=false;
        foreach ($bills as $bill){
            ?>
            <tr>
                <td>FA<?=$bill['id'] ?></td>
                <td><?=$bill['date_created'] ?></td>
                <td><?=$bill['total']?>€</td>
                <?php
                    if($bill['pay']=='null'){
                        $notPaye=true;
                        ?>
                        <td style="color:red">non réglé</td>
                        <?php
                    }else{
                        ?>
                        <td style="color:green">Payé</td>
                        <?php
                    }
                ?>
                <td><a href="<?= $this->url('view_bill', ['id' => $bill['id']]) ?>"><i class="fa fa-search" aria-hidden="true"></i></a></td>
            </tr>
            <?php
        }
        ?>
        </table>
        <button id="MakeBillsGroup"<?php if(!$notPaye){echo 'disabled';}?>>Facture Cumulé</button>
    </article>
    <article>
        <table>
            <tr>
                <th>n°Factures Groupées</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
            <?php
            foreach($billsGroup as $billGroup){
                ?>
                <tr>
                    <td>FC<?= $billGroup['id'] ?></td>
                    <td><?=$billGroup['date_created'] ?></td>
                    <td><?= $billGroup['total'] ?>€</td>
                    <?php
                    if($billGroup['pay']=='0'){
                        ?>
                        <td style="color:red">non réglé</td>
                        <?php
                    }else{
                        ?>
                        <td style="color:green">Payé</td>
                        <?php
                    }
                    ?>
                    <td><a href="<?= $this->url('view_bill_group', ['id' => $billGroup['id']]) ?>"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </article>
</div>
<?php $this->stop('main_content') ?>