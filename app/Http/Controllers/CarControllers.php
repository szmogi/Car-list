<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return $car = Car::with('Part')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        
       $regMumber = null; 

        if($request->register == 1){
            $validation = $request->validate([            
                'name' => 'required',           
                'registrationNumber' => 'required'                                
            ]);  
            $regMumber = $request->registrationNumber;             

          }else{
            $validation = $request->validate([            
                'name' => 'required',          
                                             
            ]);     
            $regMumber = 0;
          }

          
        $car = new Car;
        $car->name = $request->name;
        $car->registration_number = $regMumber;
        $car->is_registered = $request->register;
        $car->save();
    
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return $car;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        return $car;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {    

        if($request->register == 1){
            $validation = $request->validate([            
                'name' => 'required',           
                'registrationNumber' => 'required'                                
            ]);  
            $regMumber = $request->registrationNumber;             

          }else{
            $validation = $request->validate([            
                'name' => 'required',          
                                             
            ]);     
            $regMumber = 0;
          }

      

         Car::find($car);
         $car->name = $request->name;
         $car->registration_number = $regMumber;
         $car->is_registered = $request->register;
         $car->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
    }
}
