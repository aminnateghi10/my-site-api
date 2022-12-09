<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Ticket as ResourcesTicket;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    /**
     * store
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required'
        ]);

        Ticket::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return response()->json(['status' => true]);
    }

    /**
     * show
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $ticket = Ticket::orderby('created_at', 'desc')->get();

        return ResourcesTicket::collection($ticket);
    }

    /**
     * delete
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);

        $deleteStatus = $ticket->delete();

        return response()->json([
            'status' => $deleteStatus
        ]);
    }
}
