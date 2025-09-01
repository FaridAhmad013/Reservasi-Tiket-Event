<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show($id)
    {
        $event = [
            'title' => 'Uji Coba Event',
            'date' => '18 Agustus 2025',
            'time1' => '16:00',
            'time2' => '20:30',
            'location' => 'Stadion Utama Sumatera Utara'
        ];

        // nama view harus cocok dengan path
        return view('pages.detailevent.detailevent', compact('event'));
    }
}
