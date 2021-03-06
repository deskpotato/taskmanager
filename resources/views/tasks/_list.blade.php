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
                        <td>
                        <span class="badge badge-secondary mr-3">{{$todo->updated_at->diffForHumans()}}</span>
                        <a href="{{route('tasks.show',$todo->id)}}"> {{$todo->name}}</a>
                        </td>
                        <td>@include('tasks._checkFrom')</td>
                        <td>@include('tasks._editFrom')</td>
                        <td>@include('tasks._deleteFrom')</td>
                        </tr>
                    @endforeach            
                </table>
        @endif
    
    </div>
    <div class="tab-pane fade" id="done" role="tabpanel" aria-labelledby="done-tab">
        
        @if (count($dones) > 0 )
        <table class="table table-striped">

            @foreach ($dones as $done)
                <tr>
                <td> 
                  <span class="badge badge-secondary mr-3">{{$done->updated_at->diffForHumans()}}</span>
                  <a href="{{route('tasks.show',$done->id)}}"> {{$done->name}}</a>
                </td>
                </tr>
            @endforeach            
        </table>
      @endif
    </div>
  </div>