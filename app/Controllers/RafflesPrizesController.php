<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\RafflePrize\PrizeDropdownService;
use App\Libraries\RafflePrize\StoreService;
use App\Models\RaffleModel;
use App\Validation\RafflePrizeValidation;
use CodeIgniter\HTTP\RedirectResponse;

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
            'prizesOptions' => (new PrizeDropdownService)->prizesOptions($raffle->prizes ?? []), // Aqui pode ser preenchido com opções de prêmios
        ];

        // Retorna a view correspondente e passa os dados para renderização
        return view(self::VIEWS_DIRECTORY . 'manage', $data);
    }


    public function store(string $raffleCode): RedirectResponse
    {
        $rules =  (new RafflePrizeValidation)->getRules();

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $raffle = model(RaffleModel::class)->getByCode(code: $raffleCode);

        $storeService = new StoreService(raffle: $raffle, validateData:$this->validator->getValidated());

        if(!$storeService->synchonize()){
            return redirect()->back()->with('danger', 'Ocorreu um erro. Tente novamente');
        }

        return redirect()->route('raffles.show', [$raffle->code])->with('success', 'Sucesso!');
    }
}
