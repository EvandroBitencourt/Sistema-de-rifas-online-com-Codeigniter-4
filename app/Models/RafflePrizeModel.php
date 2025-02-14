<?php

namespace App\Models;

use App\Entities\Prize;
use App\Entities\Raffle;
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


    public function getByPrizesIds(array $prizesIds): array {
    
        // Seleciona as colunas desejadas da tabela 'raffles' e 'raffles_prizes'
        $this->select([
            'raffles.*', // Quero todos os campos da tabela 'raffles'
            'raffles_prizes.prize_id', // Precisamos dessa informação para uso em várias partes do código
        ]);
    
        // Realiza um JOIN entre as tabelas 'raffles' e 'raffles_prizes' com base no ID da rifa
        $this->join('raffles', 'raffles.id = raffles_prizes.raffle_id');
    
        // Filtra os resultados com base nos IDs dos prêmios fornecidos
        $this->whereIn('raffles_prizes.prize_id', $prizesIds);
    
        // Retorna os resultados como objetos da classe Raffle
        $this->asObject(Raffle::class);
    
        // Retorna todas as rifas encontradas
        return $this->findAll();
    }
    
}
