<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     

        return view('welcome',[
           'dataCars' => Car::with('Part')->get()
        ]);


    }

    public function search (Request $request){

        $search = $request->item;

      return   $data = Car::query()->where('name', 'LIKE', "%{$search}%")->get();
    }
}
