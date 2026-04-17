<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents; // Có thể bật lên để chạy nhanh hơn nếu database quá lớn

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo 1 tài khoản Admin và 1 User thường
        User::create([
            'name' => 'Admin MyJobCV',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'), // Mật khẩu chung dễ nhớ
            'role' => 1, // 1 là Admin
        ]);

        User::create([
            'name' => 'Nguyễn Ứng Viên',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 0, // 0 là User
        ]);

        // 2. Tạo 5 Danh mục nghề nghiệp
        $categories = ['IT Phần mềm', 'Marketing', 'Kinh doanh / Bán hàng', 'Kế toán', 'Thiết kế đồ họa'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat)
            ]);
        }

        // 3. Tạo 10 Công ty mẫu
        Company::factory(10)->create();

        // 4. Tạo 30 Công việc mẫu (Nó sẽ tự động bốc ngẫu nhiên ID từ bảng companies)
        Job::factory(30)->create();

        // In ra màn hình console thông báo thành công cho ngầu
        $this->command->info('Đã tạo thành công: 2 User, 5 Category, 10 Company và 30 Job!');
    }
}