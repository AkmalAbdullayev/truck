<?php

namespace App\Http\Controllers;

use App\DriverType;
use Illuminate\Http\Request;

class DriverTypeController extends Controller
{
    public function index()
    {
        $driver_types = DriverType::get();
        if (request()->filled('change') && request()->filled('driverType')){
            $driver_type = DriverType::findOrFail(\request('driverType'));
            return view('drivertype.index', compact('driver_types', 'driver_type'));
        }
        return view("drivertype.index", compact("driver_types"));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([ 'name' => 'required' ]);
        try {
            DriverType::create([ 'name' => $request->name ]);
            return redirect()->route("drivertype.index")->with('success', 'Successfully created');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([ 'name' => 'required' ]);
        try {
            $driver_type = DriverType::findOrFail($id);
            $driver_type->update(['name' => $request->name]);
            return redirect()->route('drivertype.index')->with("success", 'Successfully Updated!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $driverType = DriverType::findOrFail($id);
            $driverType->forceDelete();
            return redirect()->route('drivertype.index')->with('success', 'Successfully Deleted!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }
}
