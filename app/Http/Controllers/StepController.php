<?php

namespace App\Http\Controllers;

use App\Step;
use App\Task;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        // $task->steps()->get();
        // return $task->steps;
        return response()->json([
            'steps'=>$task->steps,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Task $task,Request $request)
    {
        $step = $task->steps()->create([
            'name'=>$request->name
        ]);
        //migration表completion default(0)需要①  ②  ③ 其中之一
        // ①$step->refresh();
        // ② App\Step protected $attributes = ['completion'=>0];  √
        // ③  $step = $task->steps()->create([
        // 'name'=>$request->name
        // 'completion'=>0
        // ]);

        // $step = $task->steps()->create($request->only('name')->refresh());

        return response()->json([
            'step'=>$step
        ],201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function show(Step $step)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function edit(Step $step)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Task $task, Step $step)
    {
        $step->update([
            'completion'=>$request->completion
        ]);
    }

    public function completeAll(Task $task)
    {
        $task->steps()->update([
            'completion'=>1
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task, Step $step)
    {
        $step->delete();
        //需要的话可以返回相应信息
        // return response()->json([
        //     'msg'=>'当前step删除成功'
        // ],204);
    }

    public function clear(Task $task)
    {
        $task->steps()->where('completion',1)->delete();
    }
}
