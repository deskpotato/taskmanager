<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use App\Repositories\ProjectsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProjectsController extends Controller
{
    protected $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo  = $repo;
        $this->middleware('auth');
    }


    public function index()
    {
        $projects  = $this->repo->list();
        
        return  view('welcome',compact('projects')); 
    }

    public function store(CreateProjectRequest $request)
    {

        $this->repo->create($request);
        //返回上一页
        return back();
    }

    // public function destroy(Project $project)
    // {
    //     $project->delete();
    //     return back();
        
    // }
    public function destroy($id)
    {
        $this->repo->delete($id);
        return back();    
    }


    public function show(Project $project)
    {
        $todos  =$this->repo->todos($project);
        $dones  =$this->repo->dones($project);



        $projects = auth()->user()->projects()->pluck('name','id');

        return view('projects.show',compact('project','todos','dones','projects'));
    }



    public function update(UpdateProjectRequest $request, $id)
    {
        $this->repo->update($request,$id);
        return back();
    }
   





  
}
