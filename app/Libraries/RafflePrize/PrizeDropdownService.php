<?php

declare(strict_types=1);

namespace App\Libraries\RafflePrize;

use App\Models\PrizeModel;

class PrizeDropdownService
{

    public function prizesOptions(array $previousPrizes = null): string
    {
        $prizes = model(PrizeModel::class)->all();

        if (empty($prizes)) {
            $anchor = '<br>Você ainda não tem prêmios criados<br>';
            $anchor .= anchor(
                uri: route_to('prizes.new'),
                title: 'Criar novo prêmio',
                attributes: ['class' => 'btn btn-outline-primary btn-sm']
            );

            return $anchor;
        }

        // Inicializa um array de opções para o campo de seleção
        $options = [];
        $options[''] = '--- Selecione um ou mais prêmios ---'; // Adiciona uma opção padrão

        // Inicializa um array para armazenar os prêmios previamente selecionados
        $selected = [];

        // Obtém os IDs dos prêmios previamente selecionados, caso existam
        $previousPrizesIds = array_column($previousPrizes ?? [], 'id');

        // Percorre a lista de prêmios disponíveis
        foreach ($prizes as $prize) {

            // Verifica se o prêmio atual está na lista de prêmios previamente selecionados
            if (in_array($prize->id, $previousPrizesIds)) {
                $selected[] = $prize->id; // Adiciona o prêmio ao array de selecionados
            }

            // Adiciona o prêmio ao array de opções, associando seu ID ao título
            $options[$prize->id] = $prize->title;
        }

        // Retorna um campo de seleção múltipla para os prêmios
        return form_multiselect(
            name: 'prizes[]', // Nome do campo
            options: $options, // Lista de prêmios disponíveis
            selected: $selected, // Prêmios previamente selecionados
            extra: [ // Atributos extras para estilização e validação
                'class' => 'form-control',
                'required' => true,
                'id' => 'prizes'
            ]
        );
    }
}
