<template>
 <div class="row justify-content-center">
        <div class="col-4 mr-3">
           
           <step-list :route="route" :steps="todos">
            <div class="card-header">
                待完成的步骤({{todos.length}})：
                <button class="btn btn-small btn-success float-right" @click="completeAll">完成所有</button>
            </div>

           </step-list>
           
           <step-input :route="route"></step-input>
        </div>

        <div class="col-4">

                 <step-list :route="route" :steps="dones">
                     <div class="card-header">
                        已完成的步骤({{dones.length}})：
                        <button class="btn btn-small btn-danger float-right" @click="clearCompleted">清除已完成</button>
                    </div>
                 </step-list>
                
        </div>

    </div>
</template>

<script>
    import StepInput from './step-input'
    import StepList from './step-list'
    
    export default {
        props:{
            route:String,
            todos:Array,
            dones:Array
        },
        components:{
            'step-input':StepInput,
            'step-list':StepList,
        },
        data(){
            return {
            }
        },
        methods:{
            completeAll(){
                axios.post(`${this.route}/complete`).then((res)=>{

                   window.location.reload()
                })
            },
            clearCompleted(){
                axios.delete(`${this.route}/clear`).then((res)=>{

                    window.location.reload()
                })
            }
        }
    }
</script>

<style>

</style>