<?php

namespace julio101290\boilerplatepayables\Database\Seeds;

use CodeIgniter\Config\Services;
use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

/**
 * Class BoilerplateSeeder.
 */
class BoilerplatePayables extends Seeder {

    /**
     * @var Authorize
     */
    protected $authorize;

    /**
     * @var Db
     */
    protected $db;

    /**
     * @var Users
     */
    protected $users;

    public function __construct() {
        $this->authorize = Services::authorization();
        $this->db = \Config\Database::connect();
        $this->users = new UserModel();
    }

    public function run() {


        // Permission
        $this->authorize->createPermission('payables-permission', 'Permission to view payables list');

        // Assign Permission to user
        $this->authorize->addPermissionToUser('payables-permission', 1);
        
        $this->authorize->createPermission('listaNotaCreditoPayables-permission', 'Permiso para la lista de notas de crédito de proveedor');
        $this->authorize->addPermissionToGroup('listaNotaCreditoPayables-permission', 'admin');
        $this->authorize->addPermissionToUser('listaNotaCreditoPayables-permission', 1);

    }

    public function down() {
        //
    }
}
