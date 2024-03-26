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
    $foods = Food::get(['id', 'group_id', 'name', 'description', 'image_url',]);
    $now = now();
    $triggerTime = Carbon::create($now->year, $now->month, $now->day, 10, 29, 0);
    if ($now->lt($triggerTime) || $now->dayOfWeek == Carbon::SATURDAY || $now->dayOfWeek == Carbon::SUNDAY) {
        $food = null;
    } else {
        $foodToday = FoodHistory::select('food_id', 'created_at')->whereDate('created_at', '>=', $now->copy()->startOfDay())->first();
        if (!$foodToday){
            $oldFoods = FoodHistory::select('food_id', 'created_at')->orderBy('created_at', 'desc')->whereDate('created_at', '<', $now->copy()->startOfDay())->limit(4)->get();
            if ($oldFoods->isNotEmpty()) {
                $group_ids = $foods->whereIn('id', $oldFoods->pluck('food_id'))->pluck('group_id');
                $food = $foods->whereNotIn('group_id', $group_ids)->random();
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
    return "<pre>".implode("\n", Food::get(['name'])->pluck('name')->toArray())."</pre>";
});

Route::get('/reroll/0000', function () {
    $foodToday = FoodHistory::select('id', 'created_at')->whereDate('created_at', '>=', now()->startOfDay())->first();
    if ($foodToday){
        $foodToday->delete();
    }
    return Redirect::route('index');
});

Route::get('/history', function (Request $request) {
    if (isset($request->limit) && $request->limit == "false"){
        $oldFoods = FoodHistory::select('food_name', 'created_at')->get();
    } else {
        $oldFoods = FoodHistory::select('food_name', 'created_at')->orderBy('created_at', 'desc')->limit(5)->get();
    }
    $oldFoods = $oldFoods->sortBy('created_at');
    $list = [];
    foreach($oldFoods->pluck('food_name', 'created_at') as $created_at => $food) {
        $date = Carbon::parse($created_at);
        $list[] = ($date->dayOfWeek == 0 ? "Chủ Nhật" : "Thứ " . $date->dayOfWeek + 1) . " (" . $date->day . "/" . $date->month . "): " . $food;
    }
    return "<pre>".implode("\n", $list)."</pre>";
});

Route::get('/phpinfo', function () {
    dd(phpinfo());
});

Route::get('/health-check', function () {
    $todayFood = Food::first(['id', 'name', 'description', 'image_url',]);
    $webUrl = url()->current();
    return view('welcome')->with(compact('todayFood', 'webUrl'));
});

Route::get('/quantity', function (Request $request) {
    if (isset($request->limit) && $request->limit == "false"){
        $oldFoods = FoodHistory::select('food_id', 'food_name', 'created_at')->get();
    } else {
        $oldFoods = FoodHistory::select('food_id', 'food_name', 'created_at')->orderBy('created_at', 'desc')->limit(20)->get();
    }
    $cooked_food_ids = $oldFoods->pluck('food_id')->unique();
    $oldFoods = $oldFoods->groupBy('food_id')->transform(function ($items, $key) {
        return [
            "count" => count($items),
            "food_name" => $items[0]->food_name
        ];
    })->sortByDesc('count');
    foreach(Food::whereNotIn('id', $cooked_food_ids)->get(['id', 'name']) as $food) {
        $oldFoods->push([
            "count" => 0,
            "food_name" => $food->name
        ]);
    }
    $list = [];
    foreach($oldFoods as $food) {
        $list[] = '(' . $food['count'] . ') ' . $food['food_name'];
    }
    return "<pre>".implode("\n", $list)."</pre>";
});
