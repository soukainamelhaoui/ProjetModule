<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function create(){
        $property = Property::all();
        return view('propertyForm', ['property' => $property,
                                    ]);
    }
    

    public function store(Request $request){
        $property = new Property();
        $id = Auth::id(); 

        $property->title = $request->input('title');
        $property->type = $request->input('type');
        $property->price = $request->input('price');
        $property->location = $request->input('location');
        $property->available_rooms = $request->input('avrooms');
        $property->description = $request->input('description');
    
        $property->user_id = $id;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/properties/', $filename);
            $property->image = $filename;
        }

        $property->save();

        return redirect('/');
    }
}