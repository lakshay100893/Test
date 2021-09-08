<?php

namespace App\Http\Controllers;

use App\DataTables\AgencieDataTable;
use App\Http\Requests\Agencie as RequestsAgencie;
use App\Models\Agencie;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgencieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AgencieDataTable $datatable)
    {
        return $datatable->render('Agencie.listing');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Agencie.Add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsAgencie $request)
    {
        $agencie = Agencie::create($request->all());

        if ($request->has('file_url')) {
            foreach ($request->file('file_url') as $files) {
                $Ext =  $files->extension();
                $name = time() . rand(1, 100) . '.' . $Ext;
                $files->move(public_path('UserFiles'), $name);
                $agencie->Files()->create(['file_url' => ('UserFiles/' . $name), 'type' => $Ext]);
            }
        }

        return redirect('/agencie')->with('success', 'Successfully Create Agencie');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agencie  $agencie
     * @return \Illuminate\Http\Response
     */
    public function show(Agencie $agencie)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agencie  $agencie
     * @return \Illuminate\Http\Response
     */
    public function edit(Agencie $agencie)
    {
        return view('Agencie.edit', ['data' => $agencie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agencie  $agencie
     * @return \Illuminate\Http\Response
     */
    public function update(RequestsAgencie $request, Agencie $agencie)
    {
        try {
            $agencie->fill($request->input())->save();

            if ($request->has('file_url')) {
                foreach ($request->file('file_url') as $files) {
                    $Ext =  $files->extension();
                    $name = time() . rand(1, 100) . '.' . $Ext;
                    $files->move(public_path('UserFiles'), $name);
                    $agencie->Files()->create(['file_url' => ('UserFiles/' . $name), 'type' => $Ext]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withInput()->with('error', 'Something Wrong. Try Again');
        }

        return redirect('/agencie')->with('success', 'Successfully Update Agencie ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agencie  $agencie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agencie $agencie)
    {
        //
    }

    public function imageDelete(Request $request, Agencie $agencie)
    {
        if ($request->ajax()) {
            // return public_path();
            if ($agencie->Files()->detach($request->id)) {
                $file = File::find($request->id);
                Storage::delete($file->file_url);
                return $file->delete();
            }
            return '0';
        }
    }
}
