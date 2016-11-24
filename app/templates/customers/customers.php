
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 30/09/16
 * Time: 18:34
 */
<?php $this->layout('layout', ['title' => 'Liste des clients']) ?>

<?php $this->start('main_content') ?>
<p><a href="<?= $this->url('add_customer') ?>"><img class="addButton" id="addCustomer" src="<?= $this->assetUrl('img/ajout.jpg') ?>"/></a></p>
<p><input type="text" id="customerSearch" autofocus/><img class="img" src="<?= $this->assetUrl('img/loupe.png') ?>"/></p>
    <table>
        <tr>
            <th>Client</th>
            <th>Ville</th>
        </tr>
        <?php
            foreach($customers as $customer){
                ?>
                    <tr id="customer<?=$customer['id']  ?>" class="item">
                        <td><?= $customer['lastname'].' '.$customer['firstname'] ;?></td>
                        <td><?= $customer['city'] ;?></td>
                        <td><a href="<?= $this->url('view_customer', ['id' => $customer['id']]) ?>"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                        <td><a href="<?= $this->url('edit_customer', ['id' => $customer['id']]) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                    </tr>
                <?php
            }
        ?>
    </table>
<?php $this->stop('main_content') ?>
