<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Ticket;

class TicketClassifier
{
    /**
     * Classify the content of a ticket using OpenAI.
     * Job: php artisan make:job ClassifyTicket
     */
    public function classify(Ticket $ticket): string
    {
        if (!config('services.openai.classify_enabled', true)) {
            return [
                'category' => $this->randomCategory(),
                'explanation' => 'Dummy explanation since classification is disabled.',
                'confidence' => 'Low',
            ];
        }

        $prompt = <<<PROMPT
        You are a ticket classification assistant.
        Classify the following ticket and respond ONLY in JSON with these keys:
        - category (Bug, Feature Request, Question, Other)
        - explanation (why you chose that category)
        - confidence (between 0 and 1)

        Ticket:
        Title: {$ticket->subject}
        Description: {$ticket->body}
        PROMPT;

        try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a classifier. Respond in JSON.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->choices[0]->message->content ?? null;

    } catch (ErrorException $e) {
        \Log::error('OpenAI general error', [
            'exception' => get_class($e),
            'message'   => $e->getMessage(),
            'trace'     => $e->getTraceAsString(),
        ]);
        return ['error' => 'OpenAI general error'];

    } catch (\Throwable $e) {
        // 🔴 Catch-all for everything else
        \Log::error('Unexpected error calling OpenAI', [
            'exception' => get_class($e),
            'message'   => $e->getMessage(),
            'trace'     => $e->getTraceAsString(),
        ]);
        return ['error' => $e->getMessage()]; // now shows the actual error
    }

        $content = $response->choices[0]->message->content ?? '{}';
        $data = json_decode($content, true);

        return $data ?: [
            'category' => 'Other',
            'explanation' => 'Could not parse response.',
            'confidence' => 'Low',
        ];
    }

    private function randomCategory(): string
    {
        $categories = ['Bug', 'Feature Request', 'Question', 'Other'];
        return $categories[array_rand($categories)];
    }
}