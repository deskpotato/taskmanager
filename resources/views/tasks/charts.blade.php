@extends('layouts.app')

@section('content')
    <div class="container">
        <canvas id="pieChart" width="100" height="100">
        </canvas>
    </div>
@endsection

@section('customJS')
<script src="{{asset('js/Chart.min.js')}}"></script>
<script>
   $(document).ready(function(){
       var data = {
            datasets: [{
                data: [{{$todoCount}},{{$doneCount}}],
                backgroundColor:[
                    '#FF6384',
                    '#36A2EB'
                ]
            }],
            labels: [
                '未完成',
                '已完成',
            ],
        };
        var ctxPie = $('#pieChart');
        var myPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: data,
            options: {
                responsive:true,
                title:{
                    display:true,
                    text:'所有任务的完成比例(总数:{{$total}})'
                }
            }
        });
      
   })
</script>
@endsection