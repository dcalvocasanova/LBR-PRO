<template>
<div>
  <div class="row">
    <div class="col-4">
      <v-chart :options="graph"  @click="onclick" />
    </div>
    <div class="col-4">
      <v-chart :options="graph_one"  @click="onclick" />
    </div>
    <div class="col-4">
      	<v-chart :options="graph_two"  @click="onclick" />
    </div>
    <div class="row">
      <div class="col-12">
        <v-chart  class="newer" :options="graph_three"  @click="onclick" />
      </div>
      <div class="col-12">
        <v-chart  class="newer2" :options="graph_four"  @click="onclick" />
      </div>

    </div>

  </div>



</div>
</template>

<script>
import ECharts from 'vue-echarts'
// include bar chart
import 'echarts/lib/chart/bar';
import "echarts/lib/chart/line";
import "echarts/lib/chart/pie";
// include tooltip and title component
import 'echarts/lib/component/tooltip';
import 'echarts/lib/component/title';
import "echarts/lib/component/toolbox";

export default {
  components: {
    'v-chart': ECharts
  },
  data(){
	 const that = this
      return {
        data: [],  
	  
    graph:{
      title:{
        text:"Ejemplo 1"
      },
      tooltip:{},
      legend:{
        orient:"vertical",
        right:10,
        top:20,
      },
      series:[{
          type:'pie',
          radius:'25%',
          cursor: 'pointer',
          labelLine: {
              show: false
          },
          data:[
            {name:"a", value:1211},
            {name:"b", value:2323},
            {name:"c", value:1919}
          ]
      }]
    },

    graph_one: {
      title: {
        text: 'Otro Ejemplo',
        subtext: 'con subtitulo',
        left: 'center'
      },
      tooltip: {
        trigger: 'item',
        formatter: '{a} <br/>{b} : {c} ({d}%)'
      },
      legend: {
        orient: 'vertical',
        left: 'left',
        data: ['tarea 1', 'tarea 2', 'tarea 3', 'tarea 4', 'tarea 5']
      },
      series: [
      {
        name: 'Tareas por niveles',
        type: 'pie',
        radius: '55%',
        center: ['50%', '60%'],
        data:[],
        emphasis: {
          itemStyle: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        }
      }]
    },

    graph_two:{
      tooltip: {
        trigger: 'item',
        formatter: '{a} <br/>{b}: {c} ({d}%)'
      },
      legend: {
        orient: 'vertical',
        left: 10,
        data: ['Tarea I', 'Tarea II', 'Tarea III', 'Tarea IV', 'Tarea V']
      },
      series: [
        {
          name: 'Tareas por objetivos',
          type: 'pie',
          radius: ['50%', '70%'],
          avoidLabelOverlap: false,
          label: {
            show: false,
            position: 'center'
          },
          emphasis: {
            label: {
              show: true,
              fontSize: '30',
              fontWeight: 'bold'
            }
          },
          labelLine: {
            show: false
          },
          data: [
            {value: 335, name: 'Tarea I'},
            {value: 310, name: 'Tarea II'},
            {value: 234, name: 'Tarea III'},
            {value: 135, name: 'Tarea IV'},
            {value: 1548, name: 'Tarea V'}
          ]
        }
      ]
    },

    graph_three:{
      title: {
        text: 'Ejemplo',
        subtext: 'Posible pareto',
        left: 'center'
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'cross',
          crossStyle: {
            color: '#999'
          }
        }
      },
      legend: {
        data: ['Macropocesos', 'Tareas', 'Procesos']
      },
      xAxis: [
        {
          type: 'category',
          data: ['1d', '2d', '3d', '4d', '5d', '6d', '7d', '8d', '9d', '10d', '11d', '12d'],
          axisPointer: {
            type: 'shadow'
          }
        }
      ],
      yAxis: [
        {
          type: 'value',
          name: 'Minutos',
          min: 0,
          max: 500,
          interval: 50,
          axisLabel: {
            formatter: '{value} m'
          }
        },
        {
          type: 'value',
          name: 'Acumulado',
          min: 0,
          max: 250,
          interval: 50,
          axisLabel: {
            formatter: '{value}'
          }
        }
      ],
      series: [
        {
          name: 'Macropocesos',
          type: 'bar',
          data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 132.6, 200.0, 260.4, 320.3]
        },
        {
          name: 'Tareas',
          type: 'bar',
          data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 208.7, 218.8, 216.0, 240.3]
        },
        {
          name: 'Procesos',
          type: 'line',
          yAxisIndex: 1,
          data: [12.0, 22.2, 33.3, 34.5, 36.3, 50.2, 55.3, 63.4, 77.0, 90.5, 132.0, 145.2]
        }
      ]
    },

    graph_four:{
      tooltip: {
        trigger: 'item',
        formatter: '{a} <br/>{b}: {c} ({d}%)'
      },
      legend: {
        orient: 'vertical',
        left: 10,
        data: ['Alimentación', 'TOMS', 'NIFS', 'TOTS', 'TIMS', 'NECESIDADES', 'BÁSICOS', 'TOMPT', 'T', 'X']
      },
      series: [
        {
          name: 'TAREAS',
          type: 'pie',
          selectedMode: 'single',
          radius: [0, '30%'],

          label: {
            position: 'inner'
          },
          labelLine: {
            show: false
          },
          data: [
            {value: 335, name: 'TAREA 1'},
            {value: 679, name: 'TAREA 2'},
            {value: 1548, name: 'TAREA 3'}
          ]
        },
        {
          name: 'TIEMPOS',
          type: 'pie',
          radius: ['40%', '55%'],
          avoidLabelOverlap: true,
          label: {
            formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
            backgroundColor: '#eee',
            borderColor: '#aaa',
            borderWidth: 1,
            borderRadius: 4,
            // shadowBlur:3,
            // shadowOffsetX: 2,
            // shadowOffsetY: 2,
            // shadowColor: '#999',
            // padding: [0, 7],
            rich: {
              a: {
                color: '#999',
                lineHeight: 22,
                align: 'center'
              },
              // abg: {
              //     backgroundColor: '#333',
              //     width: '100%',
              //     align: 'right',
              //     height: 22,
              //     borderRadius: [4, 4, 0, 0]
              // },
              hr: {
                borderColor: '#aaa',
                width: '100%',
                borderWidth: 0.5,
                height: 0
              },
              b: {
                fontSize: 16,
                lineHeight: 33
              },
              per: {
                color: '#eee',
                backgroundColor: '#334455',
                padding: [2, 4],
                borderRadius: 2
              }
            }
          },
          data: [
            {value: 335, name: 'Alimentación'},
            {value: 310, name: 'TOMS'},
            {value: 234, name: 'NIFS'},
            {value: 135, name: 'TOTS'},
            {value: 1048, name: 'TIMS'},
            {value: 251, name: 'NECESIDADES'},
            {value: 147, name: 'BÁSICOS'},
            {value: 102, name: 'TOMPT'}
          ]
        }
      ]
    }
 }
},
    methods:{
	 
 	
	
      onclick (event, instance, echarts) {
        console.log (arguments);
      },
	
	  mounted(){
		  const that = this
		  this.data =  [
          {value: 335, name: 'tarea 1'},
          {value: 310, name: 'tarea 2'},
          {value: 234, name: 'tarea 3'},
          {value: 135, name: 'tarea 4'},
          {value: 1548, name: 'tarea 5'}
        ]
		  this.graph_one['series'][0]['data'] = this.data 
		  
		  
		
	}
 }
}    
  
  </script>

 <style scoped>
 	.echarts {
 	  width: 300px;
 	  height: 300px;
    margin:auto;
 	}
  .newer{
    width: 600px;
 	  height: 300px;
    margin-left: 40px;
  }

  .newer2{
    width: 800px;
 	  height: 300px;
    margin-left: 40px;
  }
 </style>


