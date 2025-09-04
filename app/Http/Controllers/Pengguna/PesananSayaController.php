<?php

namespace App\Http\Controllers\Pengguna;

use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PesananSayaController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'pesanan_saya';
        $this->module_name = 'Halaman Pesanan Saya';
    }

    public function index()
    {

        $allow = json_encode($this->allow);
        // $icon = 'fas '

        $module = $this->module;
        $module_name = $this->module_name;
        $user = AuthCommon::user() ?? null;
        return view('pages.pengguna.pesanan_saya.list', compact('allow', 'module', 'module_name', 'user'));
    }

    public function get_list_pesanan(){
        $user = AuthCommon::user() ?? null;
        if(!$user){
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        $status = request('status') ?? null;
        try {
            $query = Transaksi::where('user_id', $user->id)
                ->with('detailEvent')
                ->with('event');

            if ($status && $status !== 'semua') {
                $query->where('status_transaksi', $status);
            }

            $data = $query->get();
            return response([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INTERNAL_ERROR
            ], 400);
        }
    }

    public function batalkan($id){
        try {
            Transaksi::where('id', $id)->where('status_transaksi', 'menunggu persetujuan')->update([
                'status_transaksi' => 'dibatalkan'
            ]);
            return response([
                'status' => true,
                'message' => 'Berhasil membatalkan transaksi'
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
