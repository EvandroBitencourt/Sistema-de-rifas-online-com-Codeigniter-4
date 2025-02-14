<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Prize extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function imageUrl(int $width = 200): string
    {

        return empty($this->image_url) ? 'Não definida' : img(src: $this->image_url, attributes: ['class' => 'img-fluid img-thumbnail', 'width' => $width]);
    }

    public function raffles(): string
    {
      

        // Verifica se a variável $this->raffles está vazia (não há rifas cadastradas)
        if (empty($this->raffles)) {
          
            return 'Não há dados para exibir'; // Retorna uma mensagem informando que não há rifas disponíveis
        }

        // Inicializa um array vazio para armazenar os títulos das rifas
        $list = [];


        // Percorre a lista de rifas e adiciona os títulos ao array $list
        foreach ($this->raffles as $raffle) {
            
            $list[] = $raffle->title;
        }


        // Retorna uma lista HTML formatada a partir do array $list
        return ul($list);
    }
}
