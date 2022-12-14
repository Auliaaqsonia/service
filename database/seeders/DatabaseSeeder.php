<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        // $this->call(ServiceSeeder::class);
        // $this->call(TimelineSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(ProductServiceCategorySeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(ProductImageSeeder::class);
        // $this->call(OrderitemsSeeder::class);
        // $this->call(CategoryProductSeeder::class);
        // $this->call(ProductServiceSeeder::class);
        // $this->call(OrdersSeeder::class);
    }
}
