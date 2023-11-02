<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_ticket;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Ticket;

class TicketController extends Controller
{
    public function Create(Event $event)
    {
        return view('tickets.create', compact('event'));
    }

    public function Store(Request $request, $event)
    {
        $data = [];
        $dulieubatbuoc = null;
        $message = [
            'name.required' => 'Tên không được để trống',
            'cost.required' => 'Chi phí không được để trống',
            'valid_until.required' => 'The valid until field is required',
            'amount' => 'Trường bắt buộc không được để trống',
            'valid_until' => 'Trường bắt buộc không được để trống',


        ];
        // Setting trường bắt buộc    
        if ($request->special_validity == 'date') {
            $dulieubatbuoc = 'valid_until';
            $data = [
                'type' => 'date',
                'date' => $request->valid_until
            ];
        } else if ($request->special_validity == 'amount') {
            $dulieubatbuoc = 'amount';
            $data = [
                'type' => 'amount',
                'amount' => $request->amount
            ];
        }
        $special_validity = json_encode($data);
        // Validate dữ liệu
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
            $dulieubatbuoc => 'required',
            
        ], $message);

        
        Event_ticket::create([
            'event_id' => $event,
            'name' => $request->name,
            'cost' => $request->cost,
            'special_validity'=>  $special_validity
        ]);
        return redirect()->action([EventController::class, 'show'], ['event' => $event])
        ->with('success', 'Đã tạo vé thành công');
    }
}
