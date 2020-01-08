<?php
namespace App\Repositories;
use Image;
class ProjectsRepository 
{
    public function create($request)
    {
        $request->user()->projects()->create([
            'name'=>$request->name,
            'thumbnail'=>$this->thumb($request),
        ]);   
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
    }
}