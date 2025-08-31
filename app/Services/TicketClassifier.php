<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Ticket;

class TicketClassifier
{
    /**
     * Classify the content of a ticket using OpenAI.
     */
    public function classify(Ticket $ticket): string
    {
        $prompt = "Classify the following support ticket into a category: " . $ticket->description;

        $response = OpenAI::responses()->create([
            'model' => 'gpt-4.1-mini',
            'input' => $prompt,
        ]);

        // Extract the text result
        $classification = $response->output_text ?? 'uncategorized';

        // Update the ticket with classification
        $ticket->update(['classification' => $classification]);

        return $classification;
    }
}