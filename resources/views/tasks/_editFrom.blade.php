<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTask-{{$todo->id}}">
   <i class="fa fa-cog"></i>
  </button>
  
  <!-- Modal -->
<div class="modal fade" id="editTask-{{$todo->id}}" tabindex="-1" role="dialog" aria-labelledby="editTask-{{$todo->id}}-Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editTask-{{$todo->id}}-Label">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        {!! Form::model($todo,['route'=>['tasks.update',$todo->id],'method'=>'PATCH']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', '任务名称：') !!}
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    {!! $errors->getBag('update-'.$todo->id)->first('name','<div class="alert alert-danger">:message</div>') !!} 
                </div>


                <div class="form-group">
                    {!! Form::label('project_id', '所属项目：') !!}
                    {!! Form::select('project_id', $projects, null, ['class'=>'form-control']) !!}
                    {!! $errors->getBag('update-'.$todo->id)->first('project','<div class="alert alert-danger">:message</div>') !!} 
                </div>


            </div>
            <div class="modal-footer">
                {!! Form::submit('编辑任务', ['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}


      </div>
    </div>
  </div>