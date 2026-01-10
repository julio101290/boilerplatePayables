<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentsPayables extends Migration {

    public function up() {
        // PaymentsPayables
        $this->forge->addField([
                'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'idpayable' => ['type' => 'bigint', 'constraint' => 20, 'null' => false],
                'importPayment' => ['type' => 'decimal', 'constraint' => 18, 'null' => false],
                'importBack' => ['type' => 'decimal', 'constraint' => 18, 'null' => false],
                'datePayment' => ['type' => 'datetime',  'null'  => false],
                'metodPayment'  => ['type' => 'varchar', 'constraint'  => 32, 'null'  => false],
                'idComplemento'  => ['type' => 'bigint', 'constraint'  => 20, 'null'  => false],
                'observaciones'  => ['type' => 'varchar', 'constraint'  => 2048, 'null'  => true],
                'idNotaCreditoPayable'  => ['type' => 'bigint', 'constraint'  => 20, 'null'  => true],
                'tipo'  => ['type' => 'varchar', 'constraint'  => 5, 'null'  => true],
                'created_at'  => ['type' => 'datetime', 'null'  => true],
                'updated_at'  => ['type' => 'datetime', 'null'  => true],
                'deleted_at'  => ['type' => 'datetime', 'null'  => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('paymentspayable', true);
    }

    public function down() {
        $this->forge->dropTable('paymentspayable', true);
    }
}
