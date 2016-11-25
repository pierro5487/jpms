<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 08/10/16
 * Time: 17:07
 */

namespace Manager;


class ServiceCategoryManager extends \W\Manager\Manager
{
    /*
     * configure la table sur laquelle va travailler la class pour les methodes héritées.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTable('service_category');
    }

}