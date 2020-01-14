@extends('layouts.app')

@section('content')
<div class="container" id="app">
     <h3>{{$task->name}}</h3>

     <div class="row justify-content-center">
        <div class="col-4 mr-3">
            <div class="card mb-4">
                <div class="card-header">待完成的步骤：</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(step,index) in inProcess">
                            @{{step.name}}
                            <span class="float-right">
                                <i class="fa fa-check" @click="toggle(step)"></i>
                                <i class="fa fa-times" @click="remove(step)"></i>
                            </span>
                    </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="form-group">
                        <label>要完成当前任务，需要哪些步骤呢</label>
                        <input type="text" v-model="newStep"class="form-control" @keyup.enter="addStep">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">已完成的步骤：</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(step,index) in processed">
                            @{{step.name}}
                            <span class="float-right">
                                <i class="fa fa-check" @click="toggle(step)"></i>
                                <i class="fa fa-times" @click="remove(step)"></i>
                            </span>
                    </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
   

</div>
@endsection

@section('customJS')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    new Vue({
        el: '#app',
        data:{
            steps:[
                {'name':'ABC','completion':false},
                {'name':'DEF','completion':false},
                {'name':'OPQ','completion':true},
            ],
            newStep:''
        },
        computed: {
            inProcess(){
                return this.steps.filter(function(step){
                    return !step.completion
                })
            },
            processed(){
                return this.steps.filter(function(step){
                    return step.completion
                })
            }

        },
        methods:{
            addStep(){
                this.steps.push({'name':this.newStep,'completion':false})
                this.newStep = ''
            },
            toggle(step){
                step.completion = !step.completion
            },
            remove(step){
                //获取在steps中的索引
                let i = this.steps.indexOf(step)
                this.steps.splice(i,1)
            }
        }
    })
</script>
@endsection