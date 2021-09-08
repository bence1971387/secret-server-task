<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Secret extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'hash' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
      ],
      'secretText' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
      ],
      'createdAt' => [
        'type' => 'TIMESTAMP',
        'null' => true,
      ],
      'expiresAt' => [
        'type' => 'TIMESTAMP',
        'null' => true,
      ],
      'remainingViews' => [
        'type' => 'INT',
        'constraint' => 5,
      ],
    ]);
    $this->forge->addKey('hash', true);
    $this->forge->createTable('secret');
  }

  public function down()
  {
    $this->forge->dropTable('secret');
  }
}
