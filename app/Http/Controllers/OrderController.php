<?php

namespace App\Http\Controllers;

use App\Company;
use App\Order;
use App\Status;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(20);
        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $statuses = Status::get();
        return view("order.create", [
            'statuses' => $statuses
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required',
            'pickup_time' => 'required',
            'weight' => 'required',
            'load_number' => 'required',
            'status_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'commodity' => 'required',
            'drive_price' => 'required',
        ]);
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'source' => \request('source'),
                'from' => $request->from,
                'to' => $request->to,
                'pickup_time' => $request->pickup_time,
                'commodity' => $request->commodity,
                'weight' => $request->weight,
                'drive_price' => $request->drive_price,
                'load_number' => $request->load_number,
                'status_id' => $request->status_id,
                'bol_image' => $request->bol_image,
            ]);
            return redirect()->route('order.index')->with('success', 'Successfully created!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Order $order)
    {
        $statuses = Status::orderBy('name')->get();
        return view('order.edit', compact( 'order', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'source' => 'required',
            'pickup_time' => 'required',
            'weight' => 'required',
            'load_number' => 'required',
            'status_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'commodity' => 'required',
            'drive_price' => 'required',
        ]);
        try {
            $order = Order::findOrFail($id)->update([
                'user_id' => auth()->id(),
                'source' => \request('source'),
                'from' => $request->from,
                'to' => $request->to,
                'pickup_time' => $request->pickup_time,
                'commodity' => $request->commodity,
                'weight' => $request->weight,
                'drive_price' => $request->drive_price,
                'load_number' => $request->load_number,
                'status_id' => $request->status_id,
                'bol_image' => $request->bol_image,
            ]);
            return redirect()->route('order.index')->with('success', 'Successfully updated!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return redirect()->route('order.index')->with('success', 'Successfully deleted!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }
}
