<?php

namespace App\Models;

use App\Entities\Raffle;
use App\Models\Basic\AppModel;

class RaffleModel extends AppModel
{
    protected $table            = 'raffles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Raffle::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'creator_id',
        'title',
        'description',
        'price',
        'total_tickets',
        'sold_tickets',
        'draw_date',
        'winning_number',
        'values_transferred',

    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setCode'];
    protected $beforeUpdate   = ['escapeData'];
}
