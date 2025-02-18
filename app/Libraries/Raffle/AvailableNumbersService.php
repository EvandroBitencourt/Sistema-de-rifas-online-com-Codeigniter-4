<?php

declare(strict_types=1); // Ativa a verificação estrita de tipos no PHP

namespace App\Libraries\Raffle;

use App\Entities\Raffle;
use App\Models\RaffleEntryModel;

class AvailableNumbersService
{

    public function get(Raffle $raffle): array
    {
        //recupero os numeros que estao comprados /  reservados
        $lockedNumbers = model(RaffleEntryModel::class)
            ->select('number')
            ->where('raffle_id', $raffle->id)
            ->orderBy('number', 'ASC')
            ->findAll();

        //recebera os numeros disponíveis
        $availablesNumbers = [];

        for ($number = 1; $number <= $raffle->total_tickets; $number++) {
            if (!in_array($number, array_column($lockedNumbers, 'number'))) {
                $availablesNumbers[] = $number;
            }
        }
        
        return $availablesNumbers;
        
    }
}
