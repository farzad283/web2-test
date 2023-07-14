<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CellarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cellars = Cellar::all();

        return response()->json(['success' => true, 'data' => $cellars]);
    }

//////////////////////////////////////////////////////////////////////////////
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
////////////////////////////////////////////////////////////////////
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $cellar = Cellar::create($data);

        return response()->json(['success' => true, 'message' => 'Cellar created successfully', 'data' => $cellar]);
    }
    /////////////////////////////////////////////////////////////////////

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cellar  $cellar
     * @return \Illuminate\Http\Response
     */
    public function show(Cellar $cellar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cellar  $cellar
     * @return \Illuminate\Http\Response
     */
    public function edit(Cellar $cellar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cellar  $cellar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cellar $cellar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cellar  $cellar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cellar $cellar)
    {
        //
    }
}
