<?php

use App\Controllers\HomeController;
use App\Controllers\PrizesController;
use App\Controllers\RafflesController;
use App\Controllers\RafflesPrizesController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class,'index'], ['as' => 'home']);


//auth
service('auth')->routes($routes);

$routes->group('raffles', ['filter' => 'session'], static function ($routes) {
    $routes->get('/', [RafflesController::class,'index'], ['as' => 'raffles']);
    $routes->get('new', [RafflesController::class,'new'], ['as' => 'raffles.new']);
    $routes->get('show/(:segment)', [RafflesController::class,'show/$1'], ['as' => 'raffles.show']);
    $routes->delete('destroy/(:segment)', [RafflesController::class,'destroy/$1'], ['as' => 'raffles.destroy']);
    $routes->post('create', [RafflesController::class,'create'], ['as' => 'raffles.create']);

    $routes->group('prizes', ['filter' => 'session'], static function ($routes) {

        $routes->get('manage/(:segment)', [RafflesPrizesController::class,'manage/$1'], ['as' => 'raffles.prizes']);
        $routes->put('store/(:segment)', [RafflesPrizesController::class,'store/$1'], ['as' => 'raffles.prizes.store']);

    });
});


$routes->group('prizes', ['filter' => 'session'], static function ($routes) {
    $routes->get('/', [PrizesController::class,'index'], ['as' => 'prizes']);
    $routes->get('new', [PrizesController::class,'new'], ['as' => 'prizes.new']);
    $routes->get('show/(:segment)', [PrizesController::class,'show/$1'], ['as' => 'prizes.show']);
    $routes->get('edit/(:segment)', [PrizesController::class,'edit/$1'], ['as' => 'prizes.edit']);
    $routes->put('update/(:segment)', [PrizesController::class,'update/$1'], ['as' => 'prizes.update']);
    $routes->delete('destroy/(:segment)', [PrizesController::class,'destroy/$1'], ['as' => 'prizes.destroy']);
    $routes->post('create', [PrizesController::class,'create'], ['as' => 'prizes.create']);
});
