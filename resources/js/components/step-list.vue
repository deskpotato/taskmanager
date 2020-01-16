<template>
    <div class="card mb-4" v-if="steps.length">
       <slot>

       </slot>
       
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item" v-for="(step,index) in steps">
                    <span @dblclick="edit(step,index)" ref="stepName">{{step.name}}</span>
                    <input type="text"  class="form-control" v-model="editStep" ref="stepInput" @keyup.enter="update(step)"  style="display:none;">
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

    
    export default {
        props:{
            steps:Array,
            route:String
        },
        data(){
            return {
                editStep:'',
            }
        },
        methods:{

            toggle(step){
                axios.patch(`${this.route}/${step.id}/toggle`,{'completion':!step.completion}).then((res)=>{
                    window.location.reload()
                })
            },
            remove(step){
                axios.delete(`${this.route}/${step.id}`).then((res)=>{
                    window.location.reload()
                })
            },
            edit(step,index){
                this.$refs.stepName[index].style.display = 'none'
                this.$refs.stepInput[index].style.display = 'block'
                this.editStep = step.name
            },
            update(step){
                 axios.patch(`${this.route}/${step.id}`,{'name':this.editStep}).then((res)=>{
                    window.location.reload()
                })
            }
        }

    }
</script>