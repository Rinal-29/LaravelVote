<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request\LocationGalleryRequest;
use App\Models\Locations;
use App\Models\LocationsGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;
use Yajra\DataTables\Facades\DataTables;

class LocationsGalleryController extends Controller
{
    public function index($id)
    {

        $locations = Locations::find($id);


        if (request()->ajax()) {
            $query = LocationsGallery::where('locations_id', $locations->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <form class="inline-block" action="' . route('dashboard.galleries.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        Hapus
                    </button>
                    ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('url', function ($item) {
                    return '
                    <img class="mx-auto" style="max-width: 150px;" src="' . $item->url . '"/>';
                })
                ->editColumn('name', function ($item) {
                    $locationName = Locations::find($item->locations_id);
                    return '<div class="content-center"> ' . $locationName->name . '  </div>';
                })
                ->rawColumns(['action', 'url', 'name'])
                ->make();
        }

        return view('pages.dashboard.galleries.index', compact('locations'));
    }

    public function create($id)
    {
        $locations = Locations::find($id);

        return view('pages.dashboard.galleries.create', compact('locations'));
    }

    public function store(LocationGalleryRequest $request, $id)
    {
        $locations = Locations::find($id);

        $files = $request->file('files');

        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $path = $file->store('public/gallery');

                LocationsGallery::create([
                    'locations_id' => $locations->id,
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard.locations.galleries.index', $locations->id);
    }

    public function destroy(LocationsGallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('dashboard.locations.galleries.index', $gallery->locations_id);
    }
}
