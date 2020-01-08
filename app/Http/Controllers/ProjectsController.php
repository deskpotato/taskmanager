<?php

namespace App\Http\Controllers;

use App\Project;
use App\Repositories\ProjectsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    protected $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo  = $repo;
    }


    public function store(Request $request)
    {

        $this->repo->create($request);
    }


  
}
