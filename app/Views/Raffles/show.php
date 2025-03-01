<?php echo $this->extend('Layouts/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>


<div class="container">
    <div class="card shadow-lg">
        <div class="card-header">
            <h4 class="card-title"><?php echo $title; ?></h4>
            <a href="<?php echo route_to('raffles') ?>" class="btn btn-secondary float-start">Listar minhas rifas</a>
        </div>

        <div class="card-body">

            <ul class="list-group mb-4">
                <li class="list-group-item active"><?php echo $raffle->title; ?></li>
                <li class="list-group-item"><strong>Preço por bilhete: </strong><?php echo $raffle->price(); ?></li>
                <li class="list-group-item"><strong>Bilhetes (números) gerados: </strong><?php echo $raffle->total_tickets; ?></li>
                <li class="list-group-item"><strong>Bilhetes (números) vendidos: </strong><?php echo $raffle->sold_tickets; ?></li>
                <li class="list-group-item"><strong>Bilhetes (números) restantes: </strong><?php echo $raffle->ticketsRemaining(); ?></li>
                <li class="list-group-item"><strong>Data do sorteio: </strong><?php echo $raffle->draw_date; ?></li>
                <li class="list-group-item"><strong>Prêmios associados: </strong><?php echo $raffle->prizes(); ?></li>
            </ul>

            <a href="<?php echo route_to('raffles.prizes', $raffle->code) ?>" class="btn btn-secondary">Gerenciar prêmios</a>

            <?php if ($raffle->sold_tickets < 1) : ?>

                <?php echo form_open(
                    action: route_to('raffles.destroy', $raffle->code),
                    attributes: ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza da exclusão");'],
                    hidden: ['_method' => 'DELETE']
                ); ?>

                <button type="submit" class="btn btn-danger">Excluir</button>

                <?php echo form_close(); ?>

            <?php endif; ?>


        </div>
    </div>
</div>


<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>


<?php echo $this->endSection(); ?>