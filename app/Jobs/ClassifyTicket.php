<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClassifyTicket implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   
        $result = $classifier->classify($this->ticket);

        // If user manually changed category, preserve it
        $result = $this->ticket->isDirty('category') ? $this->ticket->category : $result['category'];

        $this->ticket->update([
            'category' => $result['category'],
            'explanation' => $result['explanation'],
            'confidence' => $result['confidence'],
        ]);
    }

}
