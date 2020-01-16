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
    import {Message} from 'element-ui'
    import 'element-ui/lib/theme-chalk/index.css';
    export default {
        props:{
            'route':String
        },
        data(){
            return {
                newStep:''
            }
        },
        methods:{
            
            addStep(){
                axios.post(this.route,{'name':this.newStep}).then((res)=>{
                    window.location.reload()
                }).catch((err)=>{
                    if(err.response.status ===422){

                        Message.error(err.response.data.errors.name[0])
                    }
                })
            },
        }
        
    }
</script>