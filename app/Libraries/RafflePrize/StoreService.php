<?php

declare(strict_types=1);

namespace App\Libraries\RafflePrize;

use App\Entities\Raffle;
use App\Models\RafflePrizeModel;

class StoreService
{
   private RafflePrizeModel $model;

   private Raffle $raffle;

   private array $validateData;

   public function __construct(Raffle $raffle, array $validateData)
   {
     $this->model = model(RafflePrizeModel::class);
     $this->raffle = $raffle;
     $this->validateData = $validateData;
   }

   public function synchonize(): bool
   {
     try {
        //abro a transaction
        $this->model->db->transException(true)->transStart();

        //remover as anteriores
        $this->model->where(['raffle_id' => $this->raffle->id])->delete();

        //inserimos os premios
        $this->model->insertBatch($this->prepareData());

        //fecho a transaction
        $this->model->db->transComplete();

        //retorna o resultado
        return $this->model->db->transStatus();

     } catch (\Throwable $th) {
        log_message('error', '[ERROR] {exception}', ['exception' => $th]);
     }
   }

   private function prepareData(): array 
   {
     $dataProvider = [];

     foreach($this->validateData['prizes'] as $prizeId)
     {
        $dataProvider[] = [
            'raffle_id' => $this->raffle->id,
            'prize_id'  => $prizeId
        ];
     }

     return $dataProvider;
   }
   
}
