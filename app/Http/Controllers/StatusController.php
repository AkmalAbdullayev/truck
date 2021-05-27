<?php

namespace App\Http\Controllers;

use App\Company;
use App\Status;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::orderBy('name')->get();
        if (request()->filled('change') && request()->filled('status')){
            $status = Status::findOrFail(\request('status'));
            return view('status.index', compact('statuses', 'status'));
        }
        return view('status.index', compact('statuses'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([ 'name' => 'required']);
        try {
            Status::create([
                'name' => request('name'),
            ]);
            return redirect()->route('status.index')->with('success', 'Successfully created!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        abort('404');
    }

    public function update(Request $request, $id)
    {
        $request->validate([ 'name' => 'required']);
        try {
            Status::findOrFail($id)->update([
                'name' => request('name'),
            ]);
            return redirect()->route('status.index')->with('success', 'Successfully updated!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $status = Status::findOrFail($id);
            $status->delete();
            return redirect()->route('status.index')->with('success', 'Successfully deleted');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }
}
