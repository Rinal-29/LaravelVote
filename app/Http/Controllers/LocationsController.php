<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request\LocationRequest;
use App\Models\Locations;
use Yajra\DataTables\Facades\DataTables;

class LocationsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Locations::all();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="space-x-4 flex w-full justify-between">
                        <a class="inline-block border border-green-500 bg-green-500 text-white rounded-md px-3 py-1 m-1 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline" 
                            href="' . route('dashboard.locations.galleries.index', $item->id) . '">
                            Gallery
                        </a>
                        <a class="inline-block border border-gray-500 bg-gray-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-600 focus:outline-none focus:shadow-outline" 
                            href="' . route('dashboard.locations.edit', $item->id) . '">
                            Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.locations.destroy', $item->id) . '" method="POST">
                        <button class="border border-red-700 bg-red-700 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-800 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>
                    </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.locations.index');
    }

    public function create()
    {
        return view('pages.dashboard.locations.create');
    }

    public function store(LocationRequest $request)
    {
        $data = $request->all();
        Locations::create($data);

        return redirect()->route('dashboard.locations.index');
    }

    public function edit($id)
    {
        $location = Locations::find($id);
        return view('pages.dashboard.locations.edit', [
            'item' => $location,
        ]);
    }

    public function update(LocationRequest $request, $id)
    {
        $data = $request->all();

        $location = Locations::find($id);
        $location->update($data);

        return redirect()->route('dashboard.locations.index');
    }

    public function destroy($id)
    {
        $location = Locations::find($id);

        $location->delete();

        return redirect()->route('dashboard.locations.index');
    }
}
