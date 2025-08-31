<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use DB;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
      DB::enableQueryLog();
        Ticket::factory()->count(1)->create();
        dd(DB::getQueryLog());
    }
}