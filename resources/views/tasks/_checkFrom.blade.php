{!! Form::open(['route'=>['tasks.check',$todo->id],'method'=>'POST']) !!}
    <button class="btn btn-success btn-sm" type="submit">

        <i class="fa fa-check"></i>
    </button>
{!! Form::close() !!}