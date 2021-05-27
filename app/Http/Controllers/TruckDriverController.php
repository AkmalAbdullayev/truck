<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Truck;
use App\TruckDriver;
use Illuminate\Http\Request;

class TruckDriverController extends Controller
{
    public function index()
    {
        $truck_drivers = TruckDriver::paginate(20);
        $drivers = Driver::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->get();
        $trucks = Truck::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->get();
        return view('truck_driver.index', compact('truck_drivers', 'drivers', 'trucks'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'truck_id' => 'required',
            'driver_id' => 'required',
            'date' => 'required'
        ]);
        try {
            TruckDriver::create([
                'driver_id' => $request->driver_id,
                'truck_id' => $request->truck_id,
                'date' => date('Y-m-d', strtotime($request->date)),
            ]);
            return redirect()->route('truckdriver.index')->with('success', 'Successfully Created!');
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
            'truck_id' => 'required',
            'driver_id' => 'required',
            'date' => 'required'
        ]);
        try {
            TruckDriver::findOrFail($id)->update([
                'driver_id' => $request->driver_id,
                'truck_id' => $request->truck_id,
                'date' => date('Y-m-d', strtotime($request->date)),
            ]);
            return redirect()->route('truckdriver.index')->with('success', 'Successfully Updated!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            TruckDriver::destroy($id);
            return redirect()->route('truckdriver.index');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }
}
