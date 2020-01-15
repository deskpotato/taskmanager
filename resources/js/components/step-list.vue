<template>
    <div class="card mb-4" v-if="steps.length">
       <slot>

       </slot>
       
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item" v-for="(step,index) in steps">
                    <span @dblclick="edit(step)">{{step.name}}</span>
                    <span class="float-right">
                        <i class="fa fa-check" @click="toggle(step)"></i>
                        <i class="fa fa-times" @click="remove(step)"></i>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

    import { Hub } from '../event-bus.js'
    
    export default {
        props:{
            steps:Array,
            route:String
        },
        data(){
            return {

            }
        },
        methods:{

            toggle(step){
                axios.patch(`${this.route}/${step.id}`,{'completion':!step.completion}).then((res)=>{

                    //steps是Array 双向数据传流
                    step.completion = !step.completion
                })
            },
            remove(step){
                axios.delete(`${this.route}/${step.id}`).then((res)=>{
                    Hub.$emit('remove',step)
                })
            },
            edit(step){
                this.remove(step)
                Hub.$emit('edit',step)
            },
        }

    }
</script>