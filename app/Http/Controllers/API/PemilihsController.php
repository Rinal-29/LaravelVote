<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Pemilihs;
use Illuminate\Http\Request;

class PemilihsController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');

        if ($id) {
            $kandidat = Pemilihs::all();

            if ($id) {
                return Response::success(
                    $kandidat,
                    'data kandidat berhasil di dapatkan'
                );
            } else {
                return Response::error(
                    null,
                    'data kandidat tidak ditemukan',
                    404
                );
            }
        }

        $kandidat = Pemilihs::all();

        return Response::success(
            $kandidat,
            'Data kandidat berhasil di dapatkan'
        );
    }
}
