<?php

namespace App\Http\Controllers;

use App\Http\Requests\patient as RequestsPatient;
use App\Models\Department;
use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if (count($request->all()) > 0) {
            $data = Patient::where(function($query) use ($request){
                if ($request->filled('email')) {
                    $query->where('email','like','%'.$request->input('email').'%');
                }
                if ($request->filled('phone')) {
                    $query->where('phone','like','%'.$request->input('phone').'%');
                }
            })->with(['dep','hospital'])->paginate(5);
        } else {
            $data = Patient::with(['dep','hospital'])->paginate(5);
        }
        
        return view('listing',compact('data'));
    }

    public function create()
    {
        $hospital = Hospital::all();
        return view('create',compact('hospital'));
    }

    public function save(RequestsPatient $request)
    {
        Patient::create($request->all());
        return redirect()->back()->with('success','Successfully Insert');
    }

    public function deapartment(Request $request)
    {
        if($request->has('id') && $request->filled('id')){
            return Hospital::find($request->id)->dep;
        }
    }
}
