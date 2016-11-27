
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 30/09/16
 * Time: 18:34
 */
<?php $this->layout('layout', ['title' => 'Liste des clients']) ?>

<?php $this->start('main_content') ?>
<p><a class="btn btn-small btn-success" href="<?= $this->url('add_customer') ?>">Ajouter un nouveau client</a></p>
<p><input type="text" id="customerSearch" autofocus/><img class="img" src="<?= $this->assetUrl('img/loupe.png') ?>"/></p>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="text-center ">Client</th>
            <th class="text-center">Ville</th>
        </tr>
        <?php
            foreach($customers as $customer){
                ?>
                    <tr id="customer<?=$customer['id']  ?>" class="item">
                        <td class="text-center"><?= $customer['lastname'].' '.$customer['firstname'] ;?></td>
                        <td class="text-center"><?= $customer['city'] ;?></td>
                        <td class="text-center">
                            <a class="btn btn-small btn-success" href="<?= $this->url('view_customer', ['id' => $customer['id']]) ?>" title="voir la fiche client"><i class="fa fa-search" aria-hidden="true"></i></a>
                            <a class="btn btn-small btn-info" href="<?= $this->url('edit_customer', ['id' => $customer['id']]) ?>" title="modifier la fiche client"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php
            }
        ?>
    </table>
<?php $this->stop('main_content') ?>
