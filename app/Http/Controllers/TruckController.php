<?php

namespace App\Http\Controllers;

use App\Company;
use App\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::orderBy('id', 'desc')
            ->paginate(20);
        return view('truck.index', compact('trucks'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'plate_number' => 'required'
        ]);
        if (!auth()->user()->company_id){
            return redirect(route('truck.index'))->with('error', "Dispatcher's company is cannot be null");
        }
        try {
            Truck::create([
                'name' => $request->name,
                'company_id' => auth()->user()->company_id,
                'plate_number' => $request->plate_number,
                'info' => $request->info,
            ]);
            return back()->with('success', 'Successfully created!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        $truck = Truck::findOrFail($id);
        return view('truck.edit', compact('truck'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'plate_number' => 'required'
        ]);
        if (!auth()->user()->company_id){
            return redirect(route('truck.index'))->with('error', "Dispatcher's company is cannot be null");
        }
        try {
            Truck::findOrFail($id)->update([
                'name' => $request->name,
                'plate_number' => $request->plate_number,
                'info' => $request->info,
            ]);
            return back()->with('success', 'Successfully updated!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Truck $truck)
    {
        try {
            $truck->forceDelete();
            return redirect()->route('truck.index');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }
}
