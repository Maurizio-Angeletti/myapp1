<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnnunciTable extends Migration
{
    public function up()
    {
        // Definizione della tabella 'annunci'
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'titolo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'descrizione' => [
                'type' => 'TEXT',
            ],
            'prezzo' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        // Aggiungere chiave primaria
        $this->forge->addKey('id', true);
        
        // Creare la tabella
        $this->forge->createTable('annunci');
    }

    public function down()
    {
        // Drop della tabella 'annunci'
        $this->forge->dropTable('annunci');
    }
}
