<?php

declare(strict_types=1); // Ativa a verificação estrita de tipos no PHP

namespace App\Libraries\Raffle;

use App\Entities\Raffle;
use App\Models\RaffleModel;
use App\Models\RafflePrizeModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class ListService
{

    private RaffleModel $builder;

    public function __construct()
    {
        $this->builder = model(RaffleModel::class);

        $this->setWhere();
    }

    public function all(): array
    {
        // Obtém todas as rifas ordenadas pelo ID de forma decrescente
        $raffles = $this->builder->orderBy('id', 'DESC')->findAll();

        // Se não houver rifas cadastradas, retorna um array vazio
        if (empty($raffles)) {
            return [];
        }

        // Extrai apenas os IDs das rifas do array de rifas
        $rafflesIds = array_column($raffles, 'id');

        // Busca os prêmios associados às rifas com base nos IDs das rifas
        $prizes = model(RafflePrizeModel::class)->getByRafflesIds(rafflesIds: $rafflesIds);

        // Associa os prêmios às respectivas rifas
        foreach ($raffles as $raffle) {
            $raffle->prizes = array_filter($prizes, function ($prize) use ($raffle) {
                // Retorna apenas os prêmios que pertencem à rifa correspondente
                return (int) $prize->raffle_id === (int) $raffle->id;
            });
        }

        // Retorna a lista de rifas com os prêmios associados
        return $raffles;
    }

    public function single(string $code): Raffle 
    {
        $raffle = $this->builder->where(['code' => $code])->first();

        if($raffle === null){
            throw new PageNotFoundException("A rifa código {$code} não foi encontrada");
        }

        $raffle->prizes = model(RafflePrizeModel::class)->getByRafflesIds(rafflesIds: [$raffle->id]);

        return $raffle;
    }


    private function setWhere(): void
    {
        $today = Time::now()->format('Y-m-d');

        $this->builder->where('total_tickets > sold_tickets'); // quero apenas com tickets disponiveis
        $this->builder->where('winning_number', null); // que ainda nao foi sorteado
        $this->builder->where('values_transferred', 0); // valores ainda não foram para o criador da rifa

        //onde a data de sorteio seja maior que a data atual
        //pois ão queremos que o user compre números no exato momento em que o sorteio ocorrera
        $this->builder->where("draw_date >", $today);

        $this->builder->whereIn('id', function ($builder) {
            $builder->select('raffle_id')->from('raffles_prizes');
        });
    }
}
