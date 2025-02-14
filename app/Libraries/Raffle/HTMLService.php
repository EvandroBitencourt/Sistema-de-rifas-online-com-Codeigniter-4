<?php

declare(strict_types=1); // Ativa a verificação estrita de tipos no PHP

namespace App\Libraries\Raffle;

class HTMLService
{

    // Método para listar os prêmios 
    public function listPrizes(array $prizes, bool $showRoute = true): string
    {

        // Verifica se o array de prêmios está vazio
        if (empty($prizes)) {
            return 'Não há dados para exibir';
        }

        // Inicia a string contendo a estrutura HTML da lista
        $html = '<ul class="list-group list-group-horizontal">';

        // Percorre o array de prêmios
        foreach ($prizes as $prize) {

            // Verifica se a variável $showRoute está desativada (false)
            if (!$showRoute) {
                // Se não precisar exibir o link, apenas retorna a URL da imagem com largura de 250px
                $image = $prize->imageUrl(width: 250);
            } else {
                // Caso contrário, cria um link usando a função anchor()
                $image = anchor(
                    uri: route_to('prizes.show', $prize->code), // Rota para exibir o prêmio específico
                    title: $prize->imageUrl(width: 100), // Define a imagem com largura de 100px
                    attributes: [
                        'class' => 'btn btn-link', // Aplica a classe de botão estilo link do Bootstrap
                        'title' => "Gerenciar {$prize->title}", // Define um título para o link
                        'target' => '_blank' // Abre o link em uma nova aba
                    ]
                );
            }

            // Adiciona o título do prêmio dentro de um parágrafo centralizado
            $image .= "<p class='text-center'>{$prize->title}</p>";

            // Adiciona o item da lista (<li>) ao HTML, incluindo a imagem e o título do prêmio
            $html .= "<li class='list-group-item border-0 text-center'>{$image}</li>";
        }


        // Fecha a tag <ul>
        $html .= '</ul>';

        // Retorna a string contendo a estrutura HTML montada
        return $html;
    }
}
