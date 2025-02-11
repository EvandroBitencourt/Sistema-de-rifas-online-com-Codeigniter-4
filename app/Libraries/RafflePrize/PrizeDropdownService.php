<?php

declare(strict_types=1);

namespace App\Libraries\RafflePrize;

use App\Models\PrizeModel;

class PrizeDropdownService {
    public function prizesOptions(array $previousPrizes = null): string {
        $prizes = model(PrizeModel::class)->all();

        if (empty($prizes)) {
            $anchor = 'Você ainda não tem prêmios criados';
            $anchor .= anchor(
                uri: route_to('prizes.new'),
                title: 'Criar novo prêmio',
                attributes: ['class' => 'btn btn-outline-primary btn-sm']
            );

            return $anchor;
        }
    }
}
