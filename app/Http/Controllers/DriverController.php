<?php

namespace App\Http\Controllers;

use App\Driver;
use App\DriverType;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->paginate(20);
        $driver_types = DriverType::orderBy('name')
            ->get();
        return view('driver.index', compact('drivers', 'driver_types'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([ 'name' => 'required', 'driver_type_id' => 'required' ]);
        if (!auth()->user()->company_id){
            return redirect(route('driver.index'))->with('error', "Dispatcher's company is cannot be null");
        }
        try {
            Driver::create([
                'name' => $request->name,
                'driver_type_id' => $request->driver_type_id,
                'company_id' => auth()->user()->company_id
            ]);
            return redirect()->route('driver.index')->with('success', 'Successfully created!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'driver_type_id' => 'required'
        ]);
        try {
            Driver::findOrFail($id)->update([
                'name' => $request->name,
                'driver_type_id' => $request->driver_type_id,
            ]);
            return redirect()->route('driver.index')->with('success', 'Successfully created!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $driver = Driver::findOrFail($id);
            $driver->delete();
            return redirect()->route("driver.index")->with('success', 'Successfully deleted!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }
}
