<?php

use App\Models\Food;
use App\Models\FoodHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $foods = Food::get();
    $now = now();
    $triggerTime = Carbon::create($now->year, $now->month, $now->day, 10, 29, 0);
    if ($now->lt($triggerTime) || $now->dayOfWeek == Carbon::SATURDAY || $now->dayOfWeek == Carbon::SUNDAY) {
        $food = null;
    } else {
        $foodToday = FoodHistory::whereDate('created_at', '>=', $now->copy()->startOfDay())->first();
        if (!$foodToday){
            $oldFoods = FoodHistory::orderBy('created_at', 'desc')->whereDate('created_at', '<', $now->copy()->startOfDay())->limit(4)->get();
            if ($oldFoods->isNotEmpty()) {
                $food = $foods->whereNotIn('id', $oldFoods->pluck('food_id'))->random();
            } else {
                $food = $foods->random();
            }
            FoodHistory::create([
                "food_id" => $food->id,
                "food_name" => $food->name,
                "date" => $now->toDateString(),
            ]);
        } else {
            $food = $foods->where('id', $foodToday->food_id)->first();
        }
    }
    $todayFood = $food;
    $webUrl = url()->current();
    return view('welcome')->with(compact('todayFood', 'webUrl'));
})->name('index');

Route::get('/list', function () {
    return "<pre>".implode("\n", Food::get()->pluck('name')->toArray())."</pre>";
});

Route::get('/reroll/0000', function () {
    $foodToday = FoodHistory::whereDate('created_at', '>=', now()->startOfDay())->first();
    if ($foodToday){
        $foodToday->delete();
    }
    return Redirect::route('index');
});

Route::get('/history', function (Request $request) {
    if (isset($request->limit) && $request->limit == "false"){
        $oldFoods = FoodHistory::orderBy('created_at', 'desc')->get();
    } else {
        $oldFoods = FoodHistory::orderBy('created_at', 'desc')->limit(5)->get();
    }
    $oldFoods = $oldFoods->sortBy('created_at');
    $list = [];
    foreach($oldFoods->pluck('food_name', 'created_at') as $created_at => $food) {
        $date = Carbon::parse($created_at);
        $list[] = ($date->dayOfWeek == 0 ? "Chủ Nhật" : "Thứ " . $date->dayOfWeek + 1) . " (" . $date->day . "/" . $date->month . "): " . $food;
    }
    return "<pre>".implode("\n", $list)."</pre>";
});
