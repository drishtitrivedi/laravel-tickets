<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use App\Services\TicketClassifier;
use Illuminate\Support\Facades\RateLimiter;

class TicketController extends Controller
{
    protected $classifier;

    public function __construct(TicketClassifier $classifier)
    {
        $this->classifier = $classifier;
    }

    public function index()
    {
        return Ticket::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|string|in:open,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }   

        $Ticket = Ticket::create($request->all());
        return response()->json($Ticket, 201);
    }

    public function show($id)
    {
         $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'message' => 'Ticket not found'
            ], 404);
        }

        return response()->json($ticket, 200);
    }

    public function update(Request $request, $id)
    {
        // Find ticket
        $ticket = Ticket::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|string|in:open,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        } 
        $validated = $validator->validated();

        // Update fields
        $ticket->update($validated);
       
        return response()->json([
            'message' => 'Ticket updated successfully',
            'data' => $ticket
        ], 200);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'message' => 'Ticket not found'
            ], 404);
        }

        Ticket::destroy($id);

        return response()->json("Ticket deleted", 204);
    }

    public function classify($id)
    {
        $ticket = Ticket::findOrFail($id);

        if (!RateLimiter::tooManyAttempts("ticket-classify", 30)) {
            RateLimiter::hit("ticket-classify");
            $result = $this->classifier->classify($ticket);
        }

        $data = json_decode($result, true);

        if ($ticket->isDirty('category') && $ticket->wasChanged('category')) {
            // keep manual category, but update explanation & confidence
            $ticket->update([
                'explanation'  => $data['explanation'],
                'confidence'   => $data['confidence'],
            ]);
        } else {
            $ticket->update([
            'category'     => $data['category'],
            'explanation'  => $data['explanation'],
            'confidence'   => $data['confidence'],
        ]);
        }

        return response()->json([
            'message' => 'Ticket classified',
            'data' => $ticket
        ]);
    }
}
