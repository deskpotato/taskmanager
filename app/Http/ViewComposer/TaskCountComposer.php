<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use App\Repositories\TasksRepository;


class TaskCountComposer{
    protected $repo;
        
    public function __construct(TasksRepository $repo)
    {
        $this->repo = $repo;
        
    }
    //默认调取compose方法
    public function compose(View $view)
    {

        if(auth()->user()){
            $view->with([
                'total'=>$this->repo->totalCount(),
                'todoCount'=>$this->repo->todoCount(),
                'doneCount'=>$this->repo->doneCount()
            ]); 
        }   
    }

}
