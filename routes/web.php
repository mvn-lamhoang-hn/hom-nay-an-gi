<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $foods = [
        [
            'name' => 'Bún bò',
            'description' => '',
        ],
        [
            'name' => 'Bún cá',
            'description' => '',
        ],
        [
            'name' => 'Bún chả/Bánh cuốn',
            'description' => '',
        ],
        [
            'name' => 'Bún đậu',
            'description' => '',
        ],
        [
            'name' => 'Bún ngan',
            'description' => '',
        ],
        [
            'name' => 'Bún ốc',
            'description' => '',
        ],
        [
            'name' => 'Bún riêu',
            'description' => '',
        ],
        [
            'name' => 'Dê',
            'description' => '',
        ],
        [
            'name' => 'KFC',
            'description' => '',
        ],
        [
            'name' => 'Lươn',
            'description' => '',
        ],
        [
            'name' => 'Phở/cơm rang',
            'description' => '',
        ],
    ];
    $now = now();
    $triggerTime = Carbon::create($now->year, $now->month, $now->day, 11, 0, 0);
    if ($now->lt($triggerTime)) {
        $todayFood = null;
    } else {
        $foodCache = Cache::get($now->toDateString());
        if (!$foodCache) {
            $lastFoodCache = Cache::get($now->copy()->subDay()->toDateString());
            $foodCache = rand(1, count($foods));
            if ($lastFoodCache) {
                while ($lastFoodCache == $foodCache) {
                    $foodCache = rand(1, count($foods));
                }
            }
            Cache::forget($now->copy()->subDay()->toDateString());
            Cache::put($now->toDateString(), $foodCache);
            $foodCache = Cache::get($now->toDateString());
        }
        $todayFood = $foods[$foodCache - 1];
    }
    return view('welcome')->with(compact('todayFood'));
});
