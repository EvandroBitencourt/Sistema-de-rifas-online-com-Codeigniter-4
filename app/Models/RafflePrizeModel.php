<?php

namespace App\Models;

use App\Entities\Prize;
use App\Models\Basic\AppModel;


class RafflePrizeModel extends AppModel
{
    protected $table            = 'raffles_prizes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'raffle_id',
        'prize_id'
    ];


    public function getByRafflesIds(array $rafflesIds): array
    {
        // Seleciona todas as colunas da tabela 'prizes' e também a coluna 'raffle_id' da tabela 'raffles_prizes'
        $this->select([
            'prizes.*', // Quero tudo da tabela 'prizes'
            'raffles_prizes.raffle_id', // Precisamos dessa informação em vários lugares do código
        ]);

        // Faz um JOIN entre 'prizes' e 'raffles_prizes', ligando 'prizes.id' com 'raffles_prizes.prize_id'
        $this->join('prizes', 'prizes.id = raffles_prizes.prize_id');

        // Filtra os registros onde 'raffles_prizes.raffle_id' está dentro do array de IDs fornecido
        $this->whereIn('raffles_prizes.raffle_id', $rafflesIds);

        // Retorna os resultados como objetos da classe 'Prize'
        $this->asObject(Prize::class);

        // Retorna todos os registros encontrados
        return $this->findAll();
    }
}
