/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 17:43
 */
<?php $this->layout('layout', ['title' => 'Liste des autos']) ?>

<?php $this->start('main_content') ?>
<p><a href="<?= $this->url('add_car') ?>"><img class="addButton" src="<?= $this->assetUrl('img/+.jpg') ?>"/></a></p>
<p><input type="text" id="carSearch" autofocus/><img class="img" src="<?= $this->assetUrl('img/loupe.png') ?>"/></p>
<table class="table table-hover">
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
            <td><a href="<?= $this->url('view_car', ['id' => $car['id']]) ?>"><i class="fa fa-search" aria-hidden="true"></i></a></td>
            <td><a href="<?= $this->url('edit_car', ['id' => $car['id']]) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
        </tr>
        <?php
    }
    ?>
</table>
<?php $this->stop('main_content') ?>