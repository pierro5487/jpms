/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 17:43
 */
<?php $this->layout('layout', ['title' => 'Liste des autos']) ?>

<?php $this->start('main_content') ?>
<p><a class="btn btn-success btn-small" href="<?= $this->url('add_car') ?>">Ajouter une nouvelle auto</a></p>
<p><input type="text" id="carSearch" autofocus/><img class="img" src="<?= $this->assetUrl('img/loupe.png') ?>"/></p>
<table class="table table-striped table-bordered">
    <tr>
        <th>n°Immatriculation</th>
        <th>Auto</th>
    </tr>
    <?php
    foreach($cars as $car){
        ?>
        <tr id="car<?=$car['id'] ?>" class="item">
            <td><?= $car['matricule'] ;?></td>
            <td><?= $car['brand'].' '.$car['model'] ;?></td>
            <td class="text-center">
                <a class="btn btn-success btn-small" href="<?= $this->url('view_car', ['id' => $car['id']]) ?>"><i class="fa fa-search" aria-hidden="true" title="Voir la voiture"></i></a>
                <a class="btn btn-info btn-small" href="<?= $this->url('edit_car', ['id' => $car['id']]) ?>"><i class="fa fa-pencil" aria-hidden="true" title="Modfier la voiture"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<?php $this->stop('main_content') ?>