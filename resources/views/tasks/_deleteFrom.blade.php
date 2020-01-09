{!! Form::open(['route'=>['tasks.destroy',$todo->id],'method'=>'DELETE']) !!}
    <button class="btn btn-danger btn-sm" type="submit">

        <i class="fa fa-times"></i>
    </button>
{!! Form::close() !!}