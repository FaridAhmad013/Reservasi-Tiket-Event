<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    public function form_image_picker() {
        $body = view('admin.form_image_picker')->render();
        $footer = '<button type="button" id="swal-back" class="btn btn-secondary">Kembali</button>';
        $footer .= '<button type="button" id="swal-continue" class="btn btn-primary">Unggah</button>';

        return [
            'title' => 'Upload Gambar',
            'body' => $body,
            'footer' => $footer
        ];
    }

        public function store_image_picker(Request $request) {
            $request->validate([
                'file' => 'required|file|max:2048|mimes:jpeg,png,jpg,gif,svg' ,// 2048 KB adalah 2MB
                'path' => 'required'
            ], [
                'file.required' => 'Format File tidak Valid',
                'file.max' => 'Ukuran file maksimal 1 MB',
                'file.mimes' => 'Tipe file harus berupa gambar (jpeg, png, jpg, gif, svg)'
            ]);

            try {
                $file = $request->file('file');
                $path = $file->store($request->path, 'public');

                return response([
                    'status' => true,
                    'message' => 'Gambar berhasil diunggah',
                    'data' => [
                        'filename' => $path
                    ]
                ], 200);
            } catch (\Throwable $th) {
                return response([
                    'status' => false,
                    'message' => 'Gambar gagal diunggah',
                    'error' => $th->getMessage()
                ], 400);
            }
        }

    public function hapus_gambar(Request $request){
        $request->validate([
            'path' => 'required',
            'filename' => 'required'
        ]);

        $formData = $request->only([
            'path',
            'filename'
        ]);

        $filePath = $formData['path'].'/'.$formData['filename'];

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return response()->json(['message' => 'File berhasil dihapus']);
        }

        return response([
            'status' => false,
            'message' => 'File gagal dihapus, file tidak ditemukan'
        ], 400);
    }

    // public function get_gambar(Request $request){
    //     $request->validate([
    //         'path' => 'required',
    //         'filename' => 'required'
    //     ]);

    //     $formData = $request->only([
    //         'path',
    //         'filename'
    //     ]);

    //     $filePath = $formData['path'].'/'.$formData['filename'];

    //     if (!Storage::exists($filePath)) {
    //         return response([
    //             'status' => false,
    //             'message' => 'File tidak ditemukan'
    //         ], 400);
    //     }

    //     $body = [
    //         [
    //             'name' => 'file',
    //             'contents' => $filePath
    //         ]
    //     ];

    //     $run = (new NextCloudService)->getfile($body);

    //     return response($run, 200)->header('Content-Type', 'image/jpeg');
    // }
}
