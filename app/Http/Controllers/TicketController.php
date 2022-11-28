<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Resources\Ticket as ResourcesTicket;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'body'=>'required'
        ]);
        Ticket::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'body'=>$request->body,
        ]);
        return response()->json(['status'=>true],200);
    }
    public function show()
    {
        $ticket=Ticket::orderby('created_at','desc')->get();
        return new ResourcesTicket($ticket);
    }
}
