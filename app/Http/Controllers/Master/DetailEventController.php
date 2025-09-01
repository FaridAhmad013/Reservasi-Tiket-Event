<?php

namespace App\Http\Controllers\Master;

use App\DataTables\DetailEventDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Http\Controllers\Controller;
use App\Models\DetailEvent;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetailEventController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'detail_event';
        $this->module_name = 'Detail Event';
        $this->folder = 'master.detail_event';

    }

    public function index()
    {
        $id = request('id') ?? null;
        if(!$id) return redirect(route('event.index'))->with(['error' => 'Data tidak ditemukan']);

        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Admin'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Master";
        $icon = "fas fa-cog";
        $module = $this->module;
        $module_name = $this->module_name;
        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name', 'id'));
    }

    public function create()
    {
        $user = AuthCommon::user();
        if (!in_Array(@$user->role->role, ['Admin'])) {
            $body = '<h3>403 | Forbidden</h3>';
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $id = request('id') ?? null;

            $event = Event::find($id);
            if(!$event){
                return response([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 400);
            }
            $body = view('pages.' . $this->folder . '.create', [
                'module' => $this->module,
                'module_name' => $this->module_name,
                'folder' => $this->folder,
                'event' => $event,
            ])->render();
            $footer = '<button type="button" class="btn btn-secondary text-responsive" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary text-responsive" onclick="save()">Simpan</button>';
        }

        return [
            'title' => 'Tambah '. $this->module_name,
            'body' => $body,
            'footer' => $footer
        ];
    }


    public function store(Request $request)
    {

        $rules = [
            'event_id' => 'required',
            'area' => 'required',
            'deskripsi' => 'required',
            'jumlah_tiket' => 'required',
            'harga' => 'required',
            'dibuka_pada' => 'required',
            'ditutup_pada' => 'required',
        ];

        $message = [
            'required' => 'Kolom :attribute tidak boleh kosong',
        ];
        $request->validate($rules, $message);

        $formData = $request->only([
            'event_id',
            'area',
            'deskripsi',
            'jumlah_tiket',
            'harga',
            'dibuka_pada',
            'ditutup_pada',
        ]);

        try {

            $formData['status'] = 'tersedia';
            $formData['harga'] = str_replace('.', '', $formData['harga']);
            $formData['dibuka_pada'] = Carbon::createFromFormat('d-m-Y H:i:s', $formData['dibuka_pada'])->format('Y-m-d H:i:s');
            $formData['ditutup_pada'] = Carbon::createFromFormat('d-m-Y H:i:s', $formData['ditutup_pada'])->format('Y-m-d H:i:s');

            DetailEvent::create($formData);


            return response([
                'status' => true,
                'message' => ResponseConstant::RM_CREATE_SUCCESS
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_UPDATE_FAILED,
            ], 400);
        }
    }

    public function edit($id)
    {
        try {
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

            $auth = AuthCommon::user() ?? null;
             if (!in_array(@$auth->role->role, ['Admin'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            } else {

                $data->foto = json_decode($data->foto);
                $data->kordinat = explode(',', $data->kordinat);
                $body = view('pages.' . $this->folder . '.edit', [
                    'id' => $id,
                    'data' => $data,
                    'event' => $event,
                    'folder' => $this->folder,
                    'module' => $this->module,
                    'module_name' => $this->module_name,
                ])->render();
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Simpan</button>';
            }

            return [
                'title' => 'Edit ' . $this->module_name,
                'body' => $body,
                'footer' => $footer
            ];
        } catch (\Throwable $th) {
            return response([
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
                "error" => $th->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $auth = AuthCommon::user() ?? null;
        if (!in_array(@$auth->role->role, ['Admin'])) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

         $rules = [
            'event_id' => 'required',
            'area' => 'required',
            'deskripsi' => 'required',
            'jumlah_tiket' => 'required',
            'harga' => 'required',
            'dibuka_pada' => 'required',
            'ditutup_pada' => 'required',
        ];

        $message = [
            'required' => 'Kolom :attribute tidak boleh kosong',
        ];
        $request->validate($rules, $message);

        $formData = $request->only([
            'event_id',
            'area',
            'deskripsi',
            'jumlah_tiket',
            'harga',
            'dibuka_pada',
            'ditutup_pada',
        ]);

        try {

            $formData['harga'] =  (int) str_replace('.', '', $formData['harga']);
            $formData['dibuka_pada'] = Carbon::createFromFormat('d-m-Y H:i:s', $formData['dibuka_pada'])->format('Y-m-d H:i:s');
            $formData['ditutup_pada'] = Carbon::createFromFormat('d-m-Y H:i:s', $formData['ditutup_pada'])->format('Y-m-d H:i:s');
            DetailEvent::where('id', $id)->update($formData);

            return response([
                "status" => true,
                "message" => ResponseConstant::RM_UPDATE_SUCCESS,
                "data" => isset($run->data) ? $run->data : null
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "status" => false,
                "message" => ResponseConstant::RM_UPDATE_FAILED,
                "data" => []
            ], 400);
        }

    }

    public function destroy($id)
    {
        $auth = AuthCommon::user() ?? null;
        if (!in_array(@$auth->role->role, ['Admin'])) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        try {
            DetailEvent::where('id', $id)->delete();

            return response([
                'status' => true,
                'message' => ResponseConstant::RM_DELETE_SUCCESS
            ]);
        } catch (\Throwable $th) {
            return response([
                "status" => false,
                "message" => ResponseConstant::RM_DELETE_FAILED,
                "error" => $th->getMessage()
            ], 400);
        }
    }


    public function datatable(DetailEventDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}
