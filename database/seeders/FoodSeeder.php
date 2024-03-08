<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            [
                'name' => 'Cơm nhất dương chỉ',
                'description' => "Cơm chọn món",
                'image_url' => 'https://thibanglai.edu.vn/quan-com-binh-dan-ngon-o-ha-noi/imager_22155.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bún chả/Bánh cuốn',
                'description' => "Bún chả là một món ăn của Việt Nam, bao gồm bún, chả thịt lợn nướng trên than hoa và bát nước mắm chua cay mặn ngọt.\nBánh cuốn, còn gọi là bánh mướt hay bánh ướt (khi không có nhân), là một món ăn làm từ bột gạo hấp tráng mỏng, cuộn tròn, bên trong độn nhân rau hoặc thịt.",
                'image_url' => 'https://static.hotdeal.vn/images/1053/1053331/500x500/275819-t-quan-combo-bun-cha-ha-noi-banh-cuon-thanh-tri-dac-san-chinh-goc-ha-noi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'KFC',
                'description' => 'Kentucky Fried Chicken, thường được biết đến với tên gọi tắt là KFC, là một chuỗi cửa hàng đồ ăn nhanh của Mỹ chuyên về các sản phẩm gà rán có trụ sở đặt tại Louisville, Kentucky.',
                'image_url' => 'https://images.foody.vn/res/g1/6249/prof/s576x330/image-d438b7a3-220812160708.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bún đậu/Bún giả cầy',
                'description' => 'Bún đậu mắm tôm là món ăn đơn giản, dân dã trong ẩm thực miền Bắc Việt Nam. Đây là món thường được dùng như bữa ăn nhẹ, ăn chơi. Thành phần chính gồm có bún tươi, đậu hũ chiên vàng, chả cốm, nem chua,dồi chó, mắm tôm (nếu ăn với nước mắm chứng tỏ bạn là người có sự bất thường về giới tính)pha chanh, ớt và ăn kèm với các loại rau thơm như tía tô, kinh giới, rau húng, xà lách, cà pháo...',
                'image_url' => 'https://static.vinwonders.com/production/bun-dau-mam-tom-ha-noi-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lươn',
                'description' => 'Thịt lươn là thịt của các loài lươn. Đây là một nguồn nguyên liệu cho nhiều món ăn phong phú và bổ dưỡng như cháo lươn, miến lươn, gỏi lươn. Lươn có giá trị thực phẩm cao, thịt lươn được chế biến thành nhiều món ăn ngon khác nhau. Ở Việt Nam lươn có thể được dùng làm nguyên liệu của các món ăn được ưa chuộng như: cháo lươn, miến lươn, lẩu lươn, chuối om lươn...',
                'image_url' => 'https://cdn.tgdd.vn/2021/06/CookProduct/Cacmontuluon-1200x676.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phở/cơm rang',
                'description' => "Phở là một món ăn truyền thống của Việt Nam và được xem là một trong những món ăn tiêu biểu cho nền ẩm thực Việt Nam.\nCơm chiên hay cơm rang là một món cơm nấu đã được chế biến trong chảo hoặc chảo rán và thường được trộn với các thành phần khác như trứng, rau, hải sản hoặc thịt. Nó thường được ăn riêng lẻ hoặc như một món ăn kèm cho món ăn khác.",
                'image_url' => 'https://images.foody.vn/res/g63/629865/prof/s576x330/foody-mobile-pb-cr-jpg-432-636207897250143993.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bún ngan',
                'description' => 'Bún ngan là bún với ngan',
                'image_url' => 'https://giadinh.mediacdn.vn/2018/8/14/photo-2-15342566083962113623589.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bún cá',
                'description' => 'Bún cá là bún với cá.',
                'image_url' => 'https://cdn.tgdd.vn/Files/2020/04/03/1246339/cach-nau-bun-ca-ha-noi-thom-ngon-chuan-vi-khong-ta-14-760x367.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('foods')->insert($foods);
    }
}
