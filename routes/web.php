<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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

const FOODS = [
    [
        'name' => 'Cơm nhất dương chỉ',
        'description' => "Cơm chọn món",
        'image_url' => 'https://thibanglai.edu.vn/quan-com-binh-dan-ngon-o-ha-noi/imager_22155.jpg',
    ],
    [
        'name' => 'Bún chả/Bánh cuốn',
        'description' => "Bún chả là một món ăn của Việt Nam, bao gồm bún, chả thịt lợn nướng trên than hoa và bát nước mắm chua cay mặn ngọt.\nBánh cuốn, còn gọi là bánh mướt hay bánh ướt (khi không có nhân), là một món ăn làm từ bột gạo hấp tráng mỏng, cuộn tròn, bên trong độn nhân rau hoặc thịt.",
        'image_url' => 'https://static.hotdeal.vn/images/1053/1053331/500x500/275819-t-quan-combo-bun-cha-ha-noi-banh-cuon-thanh-tri-dac-san-chinh-goc-ha-noi.jpg',
    ],
    [
        'name' => 'KFC',
        'description' => 'Kentucky Fried Chicken, thường được biết đến với tên gọi tắt là KFC, là một chuỗi cửa hàng đồ ăn nhanh của Mỹ chuyên về các sản phẩm gà rán có trụ sở đặt tại Louisville, Kentucky.',
        'image_url' => 'https://images.foody.vn/res/g1/6249/prof/s576x330/image-d438b7a3-220812160708.jpg',
    ],
    [
        'name' => 'Bún đậu',
        'description' => 'Bún đậu mắm tôm là món ăn đơn giản, dân dã trong ẩm thực miền Bắc Việt Nam. Đây là món thường được dùng như bữa ăn nhẹ, ăn chơi. Thành phần chính gồm có bún tươi, đậu hũ chiên vàng, chả cốm, nem chua,dồi chó, mắm tôm (nếu ăn với nước mắm chứng tỏ bạn là người có sự bất thường về giới tính)pha chanh, ớt và ăn kèm với các loại rau thơm như tía tô, kinh giới, rau húng, xà lách, cà pháo...',
        'image_url' => 'https://static.vinwonders.com/production/bun-dau-mam-tom-ha-noi-1.jpg',
    ],
    [
        'name' => 'Lươn',
        'description' => 'Thịt lươn là thịt của các loài lươn. Đây là một nguồn nguyên liệu cho nhiều món ăn phong phú và bổ dưỡng như cháo lươn, miến lươn, gỏi lươn. Lươn có giá trị thực phẩm cao, thịt lươn được chế biến thành nhiều món ăn ngon khác nhau. Ở Việt Nam lươn có thể được dùng làm nguyên liệu của các món ăn được ưa chuộng như: cháo lươn, miến lươn, lẩu lươn, chuối om lươn...',
        'image_url' => 'https://cdn.tgdd.vn/2021/06/CookProduct/Cacmontuluon-1200x676.jpg',
    ],
    [
        'name' => 'Phở/cơm rang',
        'description' => "Phở là một món ăn truyền thống của Việt Nam và được xem là một trong những món ăn tiêu biểu cho nền ẩm thực Việt Nam.\nCơm chiên hay cơm rang là một món cơm nấu đã được chế biến trong chảo hoặc chảo rán và thường được trộn với các thành phần khác như trứng, rau, hải sản hoặc thịt. Nó thường được ăn riêng lẻ hoặc như một món ăn kèm cho món ăn khác.",
        'image_url' => 'https://images.foody.vn/res/g63/629865/prof/s576x330/foody-mobile-pb-cr-jpg-432-636207897250143993.jpg',
    ],
    [
        'name' => 'Bún ngan',
        'description' => 'Bún ngan là bún với ngan',
        'image_url' => 'https://giadinh.mediacdn.vn/2018/8/14/photo-2-15342566083962113623589.jpg',
    ],
    [
        'name' => 'Bún giả cầy',
        'description' => "Giả cầy là một món ăn khá phổ biến của người Việt trên nhiều vùng miền của đất nước, được làm từ chân giò lợn với các nguyên liệu và gia vị tẩm ướp khiến món ăn cho hương vị gần tương tự thịt cầy. Do vậy món được gọi với tên 'giả cầy'.",
        'image_url' => 'https://cdn.tgdd.vn/2021/07/CookProduct/thum-1-1200x675-1.jpg',
    ],
    [
        'name' => 'Bún cá',
        'description' => 'Bún cá là bún với cá.',
        'image_url' => 'https://cdn.tgdd.vn/Files/2020/04/03/1246339/cach-nau-bun-ca-ha-noi-thom-ngon-chuan-vi-khong-ta-14-760x367.jpg',
    ],
];

Route::get('/', function () {
    $foods = FOODS;
    $now = now();
    $triggerTime = Carbon::create($now->year, $now->month, $now->day, 10, 29, 0);
    if ($now->lt($triggerTime) || $now->dayOfWeek == Carbon::SATURDAY || $now->dayOfWeek == Carbon::SUNDAY) {
        $todayFood = null;
    } else {
        $foodCache = Cache::get($now->toDateString());
        if (!$foodCache) {
            $lastFoodCache1 = Cache::get($now->copy()->subDays(1)->toDateString());
            $lastFoodCache2 = Cache::get($now->copy()->subDays(2)->toDateString());
            $lastFoodCache3 = Cache::get($now->copy()->subDays(3)->toDateString());
            $lastFoodCache4 = Cache::get($now->copy()->subDays(4)->toDateString());
            $foodCache = rand(1, count($foods));
            if ($lastFoodCache1 || $lastFoodCache4) {
                while ($lastFoodCache1 == $foodCache || $lastFoodCache2 == $foodCache || $lastFoodCache3 == $foodCache || $lastFoodCache4 == $foodCache) {
                    $foodCache = rand(1, count($foods));
                }
            }
            Cache::put($now->toDateString(), $foodCache);
            $foodCache = Cache::get($now->toDateString());
        }
        $todayFood = $foods[$foodCache - 1];
        \Log::info($todayFood['name']);
    }
    Cache::forget($now->copy()->subDays(6)->toDateString());
    Cache::forget($now->copy()->subDays(7)->toDateString());
    Cache::forget($now->copy()->subDays(8)->toDateString());
    $webUrl = url()->current();
    return view('welcome')->with(compact('todayFood', 'webUrl'));
})->name('index');

Route::get('/list', function () {
    return implode("\n", array_column(FOODS, 'name'));
});

Route::get('/reroll/0000', function () {
    Cache::forget(now()->toDateString());
    return Redirect::route('index');
});
