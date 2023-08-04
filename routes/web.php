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
            'description' => 'Bún bò',
        ],
        [
            'name' => 'Bún cá',
            'description' => 'Bún cá',
        ],
        [
            'name' => 'Bún chả/Bánh cuốn',
            'description' => 'Bún chả/Bánh cuốn',
        ],
        [
            'name' => 'Bún đậu',
            'description' => 'Bún đậu',
        ],
        [
            'name' => 'Bún ngan',
            'description' => 'Bún ngan',
        ],
        [
            'name' => 'Bún ốc',
            'description' => 'Bún ốc',
        ],
        [
            'name' => 'Bún riêu',
            'description' => 'Bún riêu',
        ],
        [
            'name' => 'Dê',
            'description' => 'Dê',
        ],
        [
            'name' => 'KFC',
            'description' => 'KFC',
        ],
        [
            'name' => 'Lươn',
            'description' => 'Lươn',
        ],
        [
            'name' => 'Phở/cơm rang',
            'description' => 'Phở/cơm rang',
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
    $webUrl = url()->current();
    return view('welcome')->with(compact('todayFood', 'webUrl'));
});
