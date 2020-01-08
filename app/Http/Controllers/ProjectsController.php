<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Intervention\Image\ImageManagerStatic as Image;
Use Image;

class ProjectsController extends Controller
{
    public function store(Request $request)
    {

        // $path  = null;
        // if($request->hasFile('thumbnail')){
        //     $path  = $request->thumbnail->store('public/thumbs');
        // }
        // or
        // dd($request->thumbnail);
        // $thumb = $request->thumbnail;
        // $name = Str::random(40).'.'.$thumb->extension();
        // $path  = $request->thumbnail->storeAs('public/thumbs',$name);


        $request->user()->projects()->create([
            'name'=>$request->name,
            'thumbnail'=>$this->thumb($request),
        ]);
        // or 
        // Project::create([
        //     'name'=>$request->name,
        //     'thumbnail'=>$request->thumbnail,
        //     'user_id'=>xxxx
        // ]);
    }


    public function thumb($request)
    {
         $path = null;
         if($request->hasFile('thumbnail')){
            $thumb = $request->thumbnail;
            $name = $thumb->hashName();
            //存原图
            $thumb->storeAs('public/thumbs/original',$name);
            $path  =  storage_path('app/public/thumbs/cropped/'.$name);
            //存裁剪图
            Image::make($thumb)->resize(200,90)->save($path);
        }
        return $name;
        // return $request->hasFile('thumbnail') ? $request->thumbnail->store('public/thumbs') : null;
    }
}
