<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
         $validation = $request->validate([            
                'name' => 'required',           
                'serial_number' => 'required',    
                'car_id' => 'required' 
                            
            ]);       

          

          
        $part = new Part;
        $part->car_id = $request->car_id;
        $part->name = $request->name;
        $part->serial_number = $request->serial_number;       
        $part->save();
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        return $part;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part)
    {
     

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        $validation = $request->validate([            
            'name' => 'required',           
            'serial_number' => 'required',    
            'car_id' => 'required' 
                        
           ]);       

              
            
            Part::find($part);
            $part->car_id = $request->car_id;
            $part->name = $request->name;
            $part->serial_number = $request->serial_number;       
            $part->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        $part->delete();
    }
}
