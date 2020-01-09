@extends('layouts.app')

@section('content')
<div class="container">

    @if (count($projects) > 0)
    
        <div class="card-deck">
        
            @foreach ($projects as $project)
                <div class="col-3 my-3">
                
                <a href="projects/{{$project->id}}" class="card">
                        <img src="{{asset('storage/thumbs/original/'.$project->thumbnail)}}" class="card-img-top" alt="">
                        <div class="card-body">
                        <h6 class="card-title text-center">{{$project->name}}</h6>
                        </div>
                    </a>   
                </div>
            @endforeach
        
        </div>
    @endif


    @include('projects._createModel')

</div>
@endsection