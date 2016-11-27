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
<a href="<?= $this->url('add_bill') ?>" class="btn btn-success btn-small">Créer une nouvelle facture</a>
<p><input type="text" id="billSearch" autofocus/><img class="img" src="<?= $this->assetUrl('img/loupe.png') ?>"/></p>
<table class="table table-striped table-bordered">
    <tr>
        <th>n°Facture</th>
        <th>Client</th>
        <th>Date d'édition</th>
    </tr>
    <?php
    foreach($bills as $bill){
        ?>
        <tr data-idFacture="<?=$bill['id'] ?>">
            <td>FA<?= $bill['id'] ;?></td>
            <td><?= $bill['lastname'].' '.$bill['firstname'] ;?></td>
            <td><?= $bill['date_created'] ;?></td>
            <td class="text-center">
                <a href="<?= $this->url('view_bill', ['id' => $bill['id']]) ?>" class="btn btn-success btn-small"><i class="fa fa-search" aria-hidden="true"></i></a>
                <a id="deleteBill<?=$bill['id'] ?>" href="#" class="btn btn-danger btn-small deleteBill" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<?php $this->stop('main_content') ?>
