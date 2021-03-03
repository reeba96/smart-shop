<?php

namespace ICBTECH\Helpdesk\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TicketitTableSeeder extends Seeder
{
    public $tickets_min_close_period = 3; // minimum days to close tickets
    public $tickets_max_close_period = 5; // maximum days to close tickets
    public $default_closed_status_id = 2; // default status id for closed tickets
    public $categories = [
        'Technical'         => '#0014f4',
        'Billing'           => '#2b9900',
        'Customer Services' => '#7e0099',
    ];
    public $statuses = [
        'Pending' => '#e69900',
        'Solved'  => '#15a000',
        'Bug'     => '#f40700',
    ];
    public $priorities = [
        'Low'      => '#069900',
        'Normal'   => '#e1d200',
        'Critical' => '#e10000',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Create tickets statuses
        foreach ($this->statuses as $name => $color) {
            $status = \ICBTECH\Helpdesk\Models\Status::create([
                'name'  => $name,
                'color' => $color,
            ]);
        }

        // Create tickets categories
        foreach ($this->categories as $name => $color) {
            $category = \ICBTECH\Helpdesk\Models\Category::create([
                'name'  => $name,
                'color' => $color,
            ]);
        }

        // Create tickets priorities
        foreach ($this->priorities as $name => $color) {
            $priority = \ICBTECH\Helpdesk\Models\Priority::create([
                'name'  => $name,
                'color' => $color,
            ]);
        }

        $categories_qty = \ICBTECH\Helpdesk\Models\Category::count();
        $priorities_qty = \ICBTECH\Helpdesk\Models\Priority::count();
        $statuses_qty = \ICBTECH\Helpdesk\Models\Status::count();

    }
}
