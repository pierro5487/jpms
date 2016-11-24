<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/10/16
 * Time: 23:41
 */

namespace Manager;


class PersoServiceManager extends \W\Manager\Manager
{
	/*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('perso_service');
    }
}