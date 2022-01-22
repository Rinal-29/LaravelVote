<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');

        if ($id) {
            $locations = Locations::with(['galleries'])->find($id);

            if ($id) {
                return Response::success(
                    $locations,
                    'data locations berhasil di dapatkan'
                );
            } else {
                return Response::error(
                    null,
                    'data locations tidak ditemukan',
                    404
                );
            }
        }

        $locations = Locations::with(['galleries']);

        if ($name) {
            $locations->where('name', 'like', '%' . $name . '%');
        }

        return Response::success(
            $locations->paginate($limit),
            'Data location berhasil di dapatkan'
        );
    }
}
