<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table      = 'activities';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $allowedFields  = ['name', 'description', 'start_time', 'end_time', 'status', 'user_id'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'description' => 'required|min_length[5]',
        'start_time' => 'required|valid_date',
        'end_time' => 'required|valid_date',
        'status' => 'required|in_list[pending,completed,cancelled]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome da atividade é obrigatório.',
            'min_length' => 'O nome da atividade deve ter pelo menos 3 caracteres.',
        ],
        'description' => [
            'required' => 'A descrição é obrigatória.',
            'min_length' => 'A descrição deve ter pelo menos 5 caracteres.',
        ],
        'start_time' => [
            'required' => 'A data e hora de início são obrigatórias.',
            'valid_date' => 'A data e hora de início devem ser válidas.',
        ],
        'end_time' => [
            'required' => 'A data e hora de término são obrigatórias.',
            'valid_date' => 'A data e hora de término devem ser válidas.',
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'Escolha um status válido (pendente, concluída, cancelada).',
        ],
    ];
}
