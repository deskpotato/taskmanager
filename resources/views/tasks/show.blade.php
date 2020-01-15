@extends('layouts.app')

@section('content')
<div class="container" id="app">
     <h3>{{$task->name}}</h3>
     {{-- vue组件 --}}
  
    <steps route="{{route('tasks.steps.index',$task->id)}}"></steps>
</div>
@endsection
