<?php

use App\Models\Food;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $foods = [
            [
                'name' => 'Bún chả vườn cam',
                'group_id' => 2,
                'description' => "Bún chả là một món ăn của Việt Nam, bao gồm bún, chả thịt lợn nướng trên than hoa và bát nước mắm chua cay mặn ngọt.",
                'image_url' => 'https://static.hotdeal.vn/images/1053/1053331/500x500/275819-t-quan-combo-bun-cha-ha-noi-banh-cuon-thanh-tri-dac-san-chinh-goc-ha-noi.jpg',
                'created_at' => "2024-03-10 23:10:10",
                'updated_at' => "2024-03-10 23:10:10",
            ],
            [
                'name' => 'Bún đậu',
                'group_id' => 4,
                'description' => 'Bún đậu mắm tôm là món ăn đơn giản, dân dã trong ẩm thực miền Bắc Việt Nam. Đây là món thường được dùng như bữa ăn nhẹ, ăn chơi. Thành phần chính gồm có bún tươi, đậu hũ chiên vàng, chả cốm, nem chua,dồi chó, mắm tôm (nếu ăn với nước mắm chứng tỏ bạn là người có sự bất thường về giới tính)pha chanh, ớt và ăn kèm với các loại rau thơm như tía tô, kinh giới, rau húng, xà lách, cà pháo...',
                'image_url' => 'https://static.vinwonders.com/production/bun-dau-mam-tom-ha-noi-1.jpg',
                'created_at' => "2024-03-10 23:10:10",
                'updated_at' => "2024-03-10 23:10:10",
            ],
        ];

        DB::table('foods')->insert($foods);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $foods = [
            [
                'name' => 'Bún chả vườn cam',
                'group_id' => 2,
                'description' => "Bún chả là một món ăn của Việt Nam, bao gồm bún, chả thịt lợn nướng trên than hoa và bát nước mắm chua cay mặn ngọt.",
                'image_url' => 'https://static.hotdeal.vn/images/1053/1053331/500x500/275819-t-quan-combo-bun-cha-ha-noi-banh-cuon-thanh-tri-dac-san-chinh-goc-ha-noi.jpg',
                'created_at' => "2024-03-10 23:10:10",
                'updated_at' => "2024-03-10 23:10:10",
            ],
            [
                'name' => 'Bún đậu',
                'group_id' => 4,
                'description' => 'Bún đậu mắm tôm là món ăn đơn giản, dân dã trong ẩm thực miền Bắc Việt Nam. Đây là món thường được dùng như bữa ăn nhẹ, ăn chơi. Thành phần chính gồm có bún tươi, đậu hũ chiên vàng, chả cốm, nem chua,dồi chó, mắm tôm (nếu ăn với nước mắm chứng tỏ bạn là người có sự bất thường về giới tính)pha chanh, ớt và ăn kèm với các loại rau thơm như tía tô, kinh giới, rau húng, xà lách, cà pháo...',
                'image_url' => 'https://static.vinwonders.com/production/bun-dau-mam-tom-ha-noi-1.jpg',
                'created_at' => "2024-03-10 23:10:10",
                'updated_at' => "2024-03-10 23:10:10",
            ],
        ];

        foreach($foods as $food) {
            Food::where('name', $food['name'])->first()->forceDelete();
        }
    }
};
