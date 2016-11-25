<?php
namespace Manager;


class OtherServiceManager extends \W\Manager\Manager
{
	/*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('other_service');
    }
}