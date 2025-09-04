<?php

namespace App\Http\Controllers;

use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Models\DetailEvent;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show($id)
    {
        $event = Event::find($id);
        if(!$event){
            return redirect(route('main.index'))->with(['error' => 'Data tidak ditemukan']);
        }

        $event->foto = json_decode($event->foto);

        $event->foto = collect($event->foto)->map(function($item){
            return asset('storage/'.$item->value);
        });

        $event->kordinat = explode(',', $event->kordinat);

        $detail_events = DetailEvent::where('event_id', $event->id)->get();

        $user = AuthCommon::user() ?? null;

        return view('pages.detailevent.detailevent', compact('event', 'detail_events', 'user'));
    }

    public function beli_ticket_form($id)
    {
        $user = AuthCommon::user() ?? null;
        $title = 'Beli Tiket';
        if (!in_Array(@$user->role->role, ['Pengguna'])){
            $body = '<h3>403 | Forbidden</h3>';
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $data = DetailEvent::findOrFail($id);
            if(!$data){
                return response([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 400);
            }

            $event = Event::find($data->event_id);
            if(!$event){
                return response([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 400);
            }

            $tiketTerjual = $data->transaksis()
                ->where('status_transaksi', 'disetujui') 
                ->sum('kuantitas');

            // Hitung sisa tiket
            $data->sisa_tiket = $data->jumlah_tiket - $tiketTerjual;

            $title = '';
            $body = view('pages.detailevent.form_beli_tiket', compact('data', 'event'))->render();
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button><button type="button" class="btn btn-primary" onclick="save()">Pesan</button>';
        }

        return [
            'title' => $title,
            'body' => $body,
            'footer' => $footer
        ];
    }

    public function beli_ticket_store(Request $request, $id)
    {
        $user = AuthCommon::user() ?? null;
        $title = 'Beli Tiket';
        if (!in_Array(@$user->role->role, ['Pengguna'])){
            return response([
                'status' => false,
                'message' => 'Anda Tidak Mempunyai Akses'
            ], 400);
        } else {

            try {
                $data = DetailEvent::findOrFail($id);
                $request->validate([
                    'bukti_transaksi' => 'required',
                    'kuantitas' => 'required'
                ], [
                    'required' => 'Kolom :attribute wajib diisi.'
                ]);

                $formData = $request->except('_token');

                $errors = [];
                for($i = 0; $i < count($formData['bukti_transaksi']); $i++){
                    if(!$formData['bukti_transaksi'][$i]['value']){
                        $errors = ['Kolom bukti transaksi wajib diisi.'];
                    }
                }

                if(count($errors) > 0){
                    return response([
                        'status' => false,
                        'message' => 'Terdapat data yang belum sesuai',
                        'errors' => $errors
                    ], 400);
                }

                $formData['bukti_transaksi'] = json_encode($formData['bukti_transaksi']);
                $formData['event_id'] = $data->event_id;
                $formData['detail_event_id'] = $data->id;
                $formData['harga'] = $data->harga;
                $formData['user_id'] = $user->id;
                $formData['status_transaksi'] = 'menunggu persetujuan';
                $formData['nomor_transaksi'] = Util::generateTransactionNumber($data->event_id, $data->id, $user->id);
                $formData['kuantitas'] = (int) $formData['kuantitas'];
                $formData['total_harga'] = (int) $data->harga * $formData['kuantitas'];

                Transaksi::create($formData);

                return response([
                    'status' => true,
                    'message' => 'Berhasil membeli tiket, silahkan menunggu persetujuan admin'
                ], 200);
            } catch (\Throwable $th) {
                //throw $th;
                return response([
                    'status' => false,
                    'message' => ResponseConstant::RM_INTERNAL_ERROR,
                ], 400);
            }
        }
    }
}
