<?php

namespace Webkul\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Category\Database\Seeders\DatabaseSeeder as CategorySeeder;
use Webkul\Attribute\Database\Seeders\DatabaseSeeder as AttributeSeeder;
use Webkul\Core\Database\Seeders\DatabaseSeeder as CoreSeeder;
use Webkul\User\Database\Seeders\DatabaseSeeder as UserSeeder;
use Webkul\Customer\Database\Seeders\DatabaseSeeder as CustomerSeeder;
use Webkul\Inventory\Database\Seeders\DatabaseSeeder as InventorySeeder;
use Webkul\CMS\Database\Seeders\DatabaseSeeder as CMSSeeder;
use Webkul\SocialLogin\Database\Seeders\DatabaseSeeder as SocialLoginSeeder;
use ICBTECH\Helpdesk\Database\Seeders\DatabaseSeeder as TicketitTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(CoreSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CMSSeeder::class);
        $this->call(SocialLoginSeeder::class);
        $this->call(TicketitTableSeeder::class);
    }
}
