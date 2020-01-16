<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStep;
use App\Step;
use App\Task;
use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        $steps = $task->steps;
        $todos = $steps->where('completion',0)->values();
        $dones = $steps->where('completion',1)->values();
        return view('steps.show',compact('task','todos','dones'));
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
    public function store(Task $task,CreateStep $request)
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

        //优化：vuejs刷新界面，不需要返回数据
        // return response()->json([
        //     'step'=>$step
        // ],201);


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
            'name'=>$request->name
        ]);
    }

    public function toggle(Request $request,Task $task, Step $step)
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
