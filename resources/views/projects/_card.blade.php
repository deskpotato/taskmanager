<div class="col-3 my-3">
<div href="{{route('projects.show',$project->id)}}" class="card project-card">
    <ul class="icon-bar">
        <li>
           @include('projects._deleteForm')
        </li>
        <li>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProjectModal-{{$project->id}}">
            <i class="fa fa-btn fa-cog"></i>
        </button>
        </li>
    </ul>
<a href="{{route('projects.show',$project->id)}}">
    {{-- @php
        $thumb = $project->thumbnail ?? 'flower.jpg';
    @endphp --}}
        <img src="{{asset('storage/thumbs/original/'.$project->thumbnail)}}" class="card-img-top" alt="">
    </a>
        <div class="card-body">
            <a href="projects/{{$project->id}}" class="card project-card">
                <h6 class="card-title text-center">{{$project->name}}</h6>
            </a>
        </div>
    </div>   

    @include('projects._editModel')
</div>