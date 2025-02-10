<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Raffle extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts = [
        'total_tickets'       => '?integer',
        'price'               => 'integer',
        'sold_tickets'        => '?integer',
        'values_transferred'  => 'boolean',
    ];

    public function setPrice(string $price): self
    {
        $this->attributes['price'] = intval(preg_replace('/\D/', '', $price));

        return $this;
    }

    public function tickets(): string
    {
        return 'CORRIGIT YTIVKE';
    }

    public function winningNumber(): string
    {
        if ($this->isClosed()) {
            return $this->status();
        }

        return $this->winning_nummber === null ? 'Não foi dessa vez' : $this->winning_nummber;
    }


    public function status(): string
    {
        return $this->isClosed() ? 'Encerrada' : 'Aguardando sorteio';
    }


    public function price(): string
    {
        return number_to_currency(num: $this->price / 100, currency: 'BRL', fraction: 2);
    }

    public function prizes(): string
    {
        return 'Ver os premios';
    }

    public function ticketsRemaining(): int
    {
        return $this->total_tickets - $this->sold_tickets;
    }

    public function hasTicketsRemaining(): bool
    {
        return $this->ticketsRemaining() > 0;
    }


    public function isClosed(): bool
    {
        // A data do sorteio é menor do que a data atual?
        if ($this->draw_date < Time::now()->format('Y-m-d')) {
            // Sim... então está encerrado.
            return true;
        }

        return $this->winning_number !== null;
    }
}
