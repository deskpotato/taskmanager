<?php
namespace App\Repositories;

use App\Project;
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

    public function list()
    {
    
        return request()->user()->projects()->get();
    }

    public function find($id)
    {
        return Project::findOrFail($id);
    }
    public function delete($id)
    {
        $project = $this->find($id);
        $project->delete();
    }

    public function update($request,$id)
    {
        $project = $this->find($id);
        $project->name = $request->name;
        if($request->hasFile('thumbnail')){
            $project->thumbnail = $this->thumb($request);
        }
        $project->save();
    }

    public function thumb($request)
    {
         $path = null;
         if($request->hasFile('thumbnail')){
            $thumb = $request->thumbnail;
            $name = $thumb->hashName();
            //存原图
            $thumb->storeAs('public/thumbs/original',$name);
            // $path  =  storage_path('app/public/thumbs/cropped/'.$name);
            // //存裁剪图
            // Image::make($thumb)->resize(200,90)->save($path);
            return $name;
        }
    }

      //待办事项

      public function todos($project)
      {
          return  $project->tasks()->where('completion',0)->get();     
      }


      //待办事项

      public function dones($project)
      {
          return  $project->tasks()->where('completion',1)->get();     
      }

}