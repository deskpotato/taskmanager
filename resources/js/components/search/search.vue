<template>
    <div class="instant-search">
        <form  class="form-inline">
            <div class="input-group">
            
                <input type="text" class="form-control" placeholder="--实时任务检索--" aria-label="Username" aria-describedby="addon-wrapping" @focus="fetch" @blur="leave" v-model="searchStr">

                <div class="input-group-append">
                <span class="input-group-text" id="addon-wrapping"><i class="fa fa-btn fa-search"></i></span>
                </div>
            </div>
        </form>
        <ul class="list-grou" v-if="show">
            <li class="list-group-item" v-for="task in filtered">
               <a :href="url(task)"> {{task.name}}</a>
            </li>
        </ul>
    </div>
</template>
<script>
    import { Loading } from 'element-ui';
    import 'element-ui/lib/theme-chalk/index.css';
    export default {
        data(){
            return {
                tasks:[],
                show:false,
                loaded:false,
                searchStr:''
            }
        },
        computed:{
            filtered(){
                let str  = this.searchStr.trim().toLowerCase()
                return this.tasks.filter((task)=>{
                    if(task.name.toLowerCase().indexOf(str) != -1){
                        return true
                    }
                })
            }
        },
        methods:{
            fetch(){
                if(!this.loaded){
                   let loading =  Loading.service({'target':'.instant-search','spinner':'el-icon-loading'});
                    axios.get('/tasks/search').then((res)=>{
                        this.tasks = res.data.tasks
                        this.show  = true
                        this.loaded  = true
                        loading.close()
                    })
                }else{
                   this.show  = true 
                }
            },
            leave(){
                //延时，可以点击li
                setTimeout(() => {
                    this.show = false
                }, 2000);
            },
             url(task){
                return `/tasks/${task.id}`
            }
        }
    }
</script>
<style lang="scss">
    .instant-search{
        height: 3rem;
        z-index: 1000;
        .search-list{
            max-height: 30em;
            overflow: auto;
        }
    }
</style>