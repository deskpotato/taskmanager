<template>
    <div class="card">
        <div class="card-header">
            <div class="form-group">
                <label v-show="!newStep">要完成当前任务，需要哪些步骤呢</label>
                <input type="text" v-model="newStep" ref="newStep" class="form-control" @keyup.enter="addStep">
            </div>
            <button class="btn btn-small btn-success float-right" v-if="newStep" @click="addStep">添加步骤</button>
        </div>
    </div>
</template>

<script>
    import { Hub } from '../event-bus.js'

    export default {
        props:{
            'route':String
        },
        data(){
            return {
                newStep:''
            }
        },
        created(){
            Hub.$on('edit',this.edit)
        },
        methods:{
            
            addStep(){
                axios.post(this.route,{'name':this.newStep}).then((res)=>{
                    this.$emit('add',res.data.step)
                    this.newStep = ''
                })
                // this.steps.push({'name':this.newStep,'completion':false})
                // this.newStep = ''
            },
            edit(step){
                //在输入框中显示当前step的name
                this.newStep = step.name
                //focus当前的输入框
                this.$refs.newStep.focus();
            }
        }
        
    }
</script>