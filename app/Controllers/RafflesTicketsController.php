<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Raffle\AvailableNumbersService;
use App\Libraries\Raffle\ListService;

class RafflesTicketsController extends BaseController
{
    public const CHOSEN_SESSION_NUMBERS = 'chosen_session_numbers';

    private const VIEWS_DIRECTORY = 'RafflesTickets/';

    public function display(string $raffleCode)
    {
        session()->remove(self::CHOSEN_SESSION_NUMBERS);

        $raffle = (new ListService)->single(code: $raffleCode);

        $raffle->tickets_availables = (new AvailableNumbersService)->get(raffle: $raffle);

        $data = [
            'title'  => 'Escolha seus números',
            'raffle' => $raffle,
        ];

        return view(self::VIEWS_DIRECTORY .'display', $data);
    }
}
