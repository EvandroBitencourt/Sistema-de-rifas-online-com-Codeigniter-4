<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RaffleModel;

class RafflesPrizesController extends BaseController
{
    private const VIEWS_DIRECTORY = 'RafflesPrizes/'; // Diretório onde estão as views relacionadas a prêmios das rifas

    public function manage(string $raffleCode)
    {
        // Obtém os dados da rifa com base no código fornecido, incluindo os prêmios associados
        $raffle = model(RaffleModel::class)->getByCode(code: $raffleCode, withPrizes: true);

        // Monta o array de dados que será passado para a view
        $data = [
            'title' => 'Gerenciar os prêmios da rifa', // Título da página
            'raffle' => $raffle, // Dados da rifa recuperada
            'prizesOptions' => '', // Aqui pode ser preenchido com opções de prêmios
        ];

        // Retorna a view correspondente e passa os dados para renderização
        return view(self::VIEWS_DIRECTORY . 'manage', $data);
    }
}
