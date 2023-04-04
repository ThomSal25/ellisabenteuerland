<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;


class ImageController extends Controller
{
    public function indexImage()
    {
        return view('/image');
    }

    public function storeImage(Request $request)
    {
        // \Log::info(json_encode($request->all()));
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            
        ]);

        $filename = 'Ellisabenteuerland-'.$request->country.'-'.$request->area.'-'.$request->name . '.' . $request->file('image')->getClientOriginalExtension();
        $image_path = $request->file('image')->storeAs('image/all', $filename, 'public');
       
        
        $data = Image::create([
            'image' => $image_path,
            'name' => $request->name,
            'area' => $request->area,
            'country' => $request->country,
        ]);

        session()->flash('success', 'Image Upload successfully');
        \Log::info(json_encode($request->all()));
        \Log::info(json_encode($data->image));
        \Log::info(json_encode($image_path));
        return redirect()->route('image.index');
    }

    public function saveImage(Request $request)
    {
        \Log::info(json_encode($request->all()));
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            
        ]);

        $filename = 'Ellisabenteuerland-'.$request->country.'-'.$request->area.'-'.$request->name . '.' . $request->file('image')->getClientOriginalExtension();
        $image_path = $request->file('image')->storeAs('image/all', $filename, 'public');
       
        
        $data = Image::create([
            'image' => $image_path,
            'name' => $request->name,
            'area' => $request->area,
            'country' => $request->country,
        ]);

        session()->flash('success', 'Image Upload successfully');
        \Log::info(json_encode($request->all()));
        \Log::info(json_encode($data->image));
        \Log::info(json_encode($image_path));
        return redirect()->route('/home');
    }

    public function showAllImages(){
        return view('/image', ['imageList' => Image::all()]);
    }
}
