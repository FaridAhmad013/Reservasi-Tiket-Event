<?php

namespace App\Http\Controllers;

use App\Helpers\AuthCommon;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = '';
        $this->module_name = 'Halaman Beranda';
    }

    public function index()
    {

        $allow = json_encode($this->allow);

        $module = $this->module;
        $module_name = $this->module_name;
        $user = AuthCommon::user() ?? null;
        return view('pages.main', compact('allow', 'module', 'module_name', 'user'));
    }

    public function get_hot_event(){
        $data = Event::with(['detailEvents' => function ($query) {
            $query->select('event_id', 'harga');
        }])
        ->withMin('detailEvents', 'harga') // ambil harga terendah
        ->withMax('detailEvents', 'harga') // ambil harga tertinggi
        ->limit(3)
        ->get();

        if ($data->isEmpty()) {
            return response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }

        return response([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    }
}
