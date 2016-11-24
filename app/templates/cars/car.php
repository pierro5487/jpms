/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 03/10/16
 * Time: 20:57
 */
<?php $this->layout('layout', ['title' => 'Véhicule '.$car['matricule']]) ?>

<?php $this->start('main_content') ?>
<?php print_r($car); ?>
<?php $this->stop('main_content') ?>