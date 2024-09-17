<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnunciModel extends Model
{
    protected $table            = 'annunci';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Annunci::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'titolo',
        'descrizione',
        'prezzo'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'titolo' => 'required|min_length[3]|max_length[255]',
        'descrizione' => 'required|min_length[10]',
        'prezzo' => 'required|decimal|greater_than[0]',
    ];
    protected $validationMessages   = [
        'titolo' => [
            'required' => 'Il campo Titolo è obbligatorio.',
            'min_length' => 'Il Titolo deve avere almeno 3 caratteri.',
            'max_length' => 'Il Titolo non può superare i 255 caratteri.',
        ],
        'descrizione' => [
            'required' => 'Il campo Descrizione è obbligatorio.',
            'min_length' => 'La Descrizione deve avere almeno 10 caratteri.',
        ],
        'prezzo' => [
            'required' => 'Il campo Prezzo è obbligatorio.',
            'decimal' => 'Il Prezzo deve essere un numero decimale valido.',
            'greater_than' => 'Il Prezzo deve essere maggiore di 0.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
