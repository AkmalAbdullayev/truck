<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->paginate(20);
        if (request()->filled('status') && request()->filled('company')){
            Company::findOrFail(\request('company'))->update(['status' => \request('status')]);
            return redirect(route('company.index'))->with('success', 'Success!');
        }
        if (request()->filled('change') && request()->filled('company')){
            $company = Company::findOrFail(\request('company'));
            return view('company.company', compact('companies', 'company'));
        }
        return view("company.company", compact("companies"));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([ 'name' => 'required' ]);
        try {
            Company::create([ 'name' => $request->name ]);
            return redirect()->route('company.index')->with('success', 'success');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        try {
            Company::findOrFail($id)->update(['name' => $request->name]);
            return back()->with('success', 'Successfully Updated!');
        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return back()->with('success', 'Successfully deleted!');
        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
