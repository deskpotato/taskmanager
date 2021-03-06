@extends('layouts.app')

@section('content')
 <div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo" role="tab" aria-controls="todo" aria-selected="true">待办事项
            <span class="badge badge-pill badge-danger">{{count($todos)}}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="done-tab" data-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">已完成
            <span class="badge badge-pill badge-success">{{count($dones)}}</span>
          </a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="todo" role="tabpanel" aria-labelledby="todo-tab">
        
            @if (count($todos) > 0 )
                    <table class="table table-striped">
    
    
                        @foreach ($todos as $todo)
                            <tr>
                            <td> <span class="badge badge-secondary mr-3">{{$todo->updated_at->diffForHumans()}}</span>
                              {{$todo->name}}
                            </td>
                            <td>@include('tasks._checkFrom')</td>
                            <td>@include('tasks._editFrom')</td>
                            <td>@include('tasks._deleteFrom')</td>
                            </tr>
                        @endforeach   

                    </table>
                    <div class="fa-pull-right"> {{$todos->links()}}</div>
            @endif
        
        </div>
        <div class="tab-pane fade" id="done" role="tabpanel" aria-labelledby="done-tab">
            
            @if (count($dones) > 0 )
            <table class="table table-striped">
    
                @foreach ($dones as $done)
                    <tr>
                    <td>{{$done->name}}</td>
                    </tr>
                @endforeach            
            </table>
            <div class="fa-pull-right"> {{$dones->links()}}</div>
          @endif
        </div>
      </div>
 </div>

@endsection