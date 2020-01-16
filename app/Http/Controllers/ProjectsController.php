<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use App\Repositories\ProjectsRepository;
use Illuminate\Support\Carbon;

class ProjectsController extends Controller
{
    protected $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth');
    }

    public function index()
    {
        $timezone = 'Asia/Shanghai';
        $current = Carbon::create(null, null, null, null, null, null, $timezone);//当前时间
        $xiaonian = Carbon::create(2020, 1, 17, 0, 0, 0, $timezone);//小年开始
        $yuanxiaojie = Carbon::create(2020, 2, 9, 0, 0, 0, $timezone);//元宵节第二天零点
        if ($current->greaterThan($xiaonian) && $current->lessThan($yuanxiaojie)) {
            //小年<--->元宵节期间
            // dd('过年期间');
        } else {
            // dd('未过年or过完年了');
        }
        $projects = $this->repo->list();

        return view('welcome', compact('projects'));
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
        $todos = $this->repo->todos($project);
        $dones = $this->repo->dones($project);

        $projects = auth()->user()->projects()->pluck('name', 'id');

        return view('projects.show', compact('project', 'todos', 'dones', 'projects'));
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $this->repo->update($request, $id);
        return back();
    }

}
