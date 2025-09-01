<?php

namespace App\Http\Controllers\Master;

use App\DataTables\EventDataTable;
use App\DataTables\UserDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'event';
        $this->module_name = 'Event';
        $this->folder = 'master.event';

    }

    public function index()
    {
        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Admin'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Master";
        $icon = "fas fa-clipboard-list";
        $module = $this->module;
        $module_name = $this->module_name;
        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name'));
    }

    public function show($id)
    {
        try {
            $auth = AuthCommon::user() ?? null;
            $data = User::where('id', $id)->with('role')->first();
            if(!in_array($auth->role->role, ['Admin'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }else{
                $body = view('pages.'.$this->folder.'.show', compact('data'))->render();
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

    public function show_gambar($id)
    {
        try {
            $auth = AuthCommon::user() ?? null;
            $data = Event::where('id', $id)->first();
            if(!in_array($auth->role->role, ['Admin'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }else{

                $data->foto = json_decode($data->foto);
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

    public function show_lokasi($id)
    {
        try {
            $auth = AuthCommon::user() ?? null;
            $data = Event::where('id', $id)->first();
            if(!in_array($auth->role->role, ['Admin'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
            }else{
                $data->kordinat = explode(',', $data->kordinat);
                $body = view('pages.'.$this->folder.'.show_lokasi', compact('data'))->render();
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

    public function create()
    {
        $user = AuthCommon::user();
        if (!in_Array(@$user->role->role, ['Admin'])) {
            $body = '<h3>403 | Forbidden</h3>';
            $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
        } else {
            $body = view('pages.' . $this->folder . '.create', [
                'module' => $this->module,
                'module_name' => $this->module_name,
                'folder' => $this->folder,
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
            'nama_event' => 'required',
            'deskripsi' => 'required',
            'waktu_event' => 'required',
            'lokasi' => 'required',
            'foto' => 'required',
            'kordinat' => 'required'
        ];

        $message = [
            'required' => 'Kolom :attribute tidak boleh kosong',
        ];
        $request->validate($rules, $message);

        $formData = $request->only([
            'nama_event',
            'deskripsi',
            'waktu_event',
            'lokasi',
            'kordinat',
            'foto',
        ]);

        try {

            if($formData['foto']){
                $formData['foto']  = json_encode($formData['foto']);
            }

            if (!empty($formData['waktu_event'])) {
                $formData['waktu_event'] = Carbon::createFromFormat('d-m-Y H:i:s', $formData['waktu_event'])->format('Y-m-d H:i:s');
            }

            Event::create($formData);

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
            $data = Event::findOrFail($id);

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
            'nama_event' => 'required',
            'deskripsi' => 'required',
            'waktu_event' => 'required',
            'lokasi' => 'required',
            'foto' => 'required',
            'kordinat' => 'required'
        ];

        $message = [
            'required' => 'Kolom :attribute tidak boleh kosong',
        ];
        $request->validate($rules, $message);

        $formData = $request->only([
            'nama_event',
            'deskripsi',
            'waktu_event',
            'lokasi',
            'kordinat',
            'foto',
        ]);

        try {
            if($formData['foto']){
                $formData['foto']  = json_encode($formData['foto']);
            }

            if (!empty($formData['waktu_event'])) {
                $formData['waktu_event'] = Carbon::createFromFormat('d-m-Y H:i:s', $formData['waktu_event'])->format('Y-m-d H:i:s');
            }

            Event::where('id', $id)->update($formData);

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
            Event::where('id', $id)->delete();

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


    public function datatable(EventDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}
