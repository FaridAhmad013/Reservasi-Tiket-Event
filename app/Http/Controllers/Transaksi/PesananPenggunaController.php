<?php

namespace App\Http\Controllers\Transaksi;

use App\DataTables\DetailEventDataTable;
use App\DataTables\PesananPenggunaDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Http\Controllers\Controller;
use App\Models\DetailEvent;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesananPenggunaController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'pesanan_pengguna';
        $this->module_name = 'Pesanan Pengguna';
        $this->folder = 'transaksi.pesanan_pengguna';

    }

    public function index()
    {
        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Admin'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Transaksi";
        $icon = "fas fa-shopping-basket";
        $module = $this->module;
        $module_name = $this->module_name;
        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name'));
    }

    public function show_gambar($id)
    {
        try {
            $auth = AuthCommon::user() ?? null;
            $data = Transaksi::where('id', $id)->first();
            if(!in_array($auth->role->role, ['Admin'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }else{

                $data->bukti_transaksi = json_decode($data->bukti_transaksi);
                $body = view('pages.'.$this->folder.'.show_gambar', compact('data'))->render();
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }

            return [
                'title' => 'Detail '.$this->module_name,
                'body' => $body,
                'footer' => $footer
            ];
        } catch (\Throwable $th) {
            //throw $th;

            return response([
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
                "error" => $th->getMessage()
            ], 400);
        }
    }


    public function datatable(PesananPenggunaDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}
