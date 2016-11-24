<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 11/10/16
 * Time: 20:31
 */
?>
<?php $this->layout('layout', ['title' => 'Liste des factures']) ?>

<?php $this->start('main_content') ?>
<a href="<?= $this->url('add_bill') ?>"><img class="addButton" src="<?= $this->assetUrl('img/+.jpg') ?>"/></a>
<p><input type="text" id="billSearch" autofocus/><img class="img" src="<?= $this->assetUrl('img/loupe.png') ?>"/></p>
<table>
    <tr>
        <th>n°Facture</th>
        <th>Client</th>
        <th>Date d'édition</th>
    </tr>
    <?php
    foreach($bills as $bill){
        ?>
        <tr id="bill<?=$bill['id'] ?>">
            <td>FA<?= $bill['id'] ;?></td>
            <td><?= $bill['lastname'].' '.$bill['firstname'] ;?></td>
            <td><?= $bill['date_created'] ;?></td>
            <td><a href="<?= $this->url('view_bill', ['id' => $bill['id']]) ?>"><i class="fa fa-search" aria-hidden="true"></i></a></td>
            <td  id="deleteBill<?=$bill['id'] ?>" class="deleteBill"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
        <?php
    }
    ?>
</table>
<?php $this->stop('main_content') ?>
