<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 21/10/16
 * Time: 15:35
 */

namespace Manager;


class ModelManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('model');
    }
}