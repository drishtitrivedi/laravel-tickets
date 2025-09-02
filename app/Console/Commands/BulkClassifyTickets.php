<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BulkClassifyTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bulk-classify-tickets {--limit=20}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Classify multiple unclassified tickets with OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $limit = (int) $this->option('limit');

        $tickets = Ticket::whereNull('classification_explanation')
            ->limit($limit)
            ->get();

        foreach ($tickets as $ticket) {
            ClassifyTicket::dispatch($ticket);
            $this->info("Queued classification for ticket #{$ticket->id}");
        }
    }
}
