<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use DB;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::factory()->count(25)->create();
    }
}