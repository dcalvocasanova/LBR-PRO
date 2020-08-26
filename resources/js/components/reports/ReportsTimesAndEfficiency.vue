<template>
<div>
  <loader :active="loadingPage" spinner="bar-fade-scale" size="90"/>
  <div class="container container-project">
    <div class="col-12">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="bmd-label-floating">Proyecto</label>
            <select @change="selectedProject" v-model="projectPickedId" class=" form-control">
              <option v-for="p in Projects.data" :value="p.id">{{ p.name }}</option>
            </select>
          </div>
        </div>
        <div class="col-md-4" v-if="showOptions">
          <div class="lbpradio">
              <div class="lbpradio-danger">
                  <input @click="showUsers" type="radio" name="radio" id="radio1" v-model="checks[0]" value="1" />
                  <label for="radio1">Usuario</label>
              </div>
              <div class="lbpradio-danger">
                  <input @click="showStrutureInformation" type="radio" name="radio" id="radio2"  v-model="checks[1]" value="1"/>
                  <label for="radio2">Estructura</label>
              </div>
          </div>
        </div>
        <div class="col-md-4" v-if="showProductType">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label class="bmd-label-floating">Por nivel</label>
                <select @change="selectByLevel" v-model="levelPicked" id="levelPicker"  class=" form-control">
                  <option v-for="l in Levels" :key="l" :value="l">{{ l }}</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4" v-if="showUserType">
          <div class="row">
            <div class="col-12">
              <div class="card card-plain">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th> Identificación </th>
                          <th> Nombre </th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr  v-for="user in Users.data" :key="user.id">
                            <td @click="getUserData(user)" v-text="user.identification"></td>
                            <td @click="getUserData(user)" v-text="user.name"></td>
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <pagination :data="Users" @pagination-change-page="loadUsers"></pagination>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-12" v-if="showNodata">
      <h2 class="text-center">No hay datos para presentar</h2>
    </div>
    <div class="col-12" v-if="showGraphics">
      <v-chart :options="graph" :key="key_graph_two" class="chart"/>
    </div>
    <div class="col-12" v-if="showData">
      <!-- item -->
      <div class="col-md-4 text-center">
       <div class="panel panel-danger panel-pricing">
         <div class="panel-heading">
             <i class="fa fa-desktop"></i>
             <h3>Plan 1</h3>
         </div>
         <div class="panel-body text-center">
             <p><strong>$100 / Month</strong></p>
         </div>
         <ul class="list-group text-center">
             <li class="list-group-item"><i class="fa fa-check"></i> Personal use</li>
             <li class="list-group-item"><i class="fa fa-check"></i> Unlimited projects</li>
             <li class="list-group-item"><i class="fa fa-check"></i> 27/7 support</li>
         </ul>
         <div class="panel-footer">
             <a class="btn btn-lg btn-block btn-danger" href="#">BUY NOW!</a>
         </div>
        </div>
      </div>
      <!-- /item -->
    </div>
  </div>
</div>
</template>

<script>
import ECharts from 'vue-echarts'
import VueElementLoading from 'vue-element-loading'
import 'echarts/lib/chart/bar';
import 'echarts/lib/chart/line';
import 'echarts/lib/chart/pie';
import 'echarts/lib/component/tooltip';
import 'echarts/lib/component/legend';
import 'echarts/lib/component/title';
import 'echarts/lib/component/toolbox';

export default {
  components: {
    'v-chart': ECharts,
    'loader': VueElementLoading
  },
  data() {
    return{
      dataToShowInGraph:{},
      datos:[],
      checks:[],
      legends:[],
      Projects:{},
      Levels:{},
      Frecuencies:{},
      Users:{},
      tipo:"",
      projectPickedId:0,
      key_graph_two:0,
      levelPicked:'',
      productPicked:'',
      frecuencyPicked:'',
      showOptions:false,
      showProductType:false,
      showFrecuencyType:false,
      showUserType:false,
      showUser:false,
      showData:false,
      showGraphics:false,
      showNodata:false,
      loadingPage:true,
      data_graph1:{},
      ready: false,
      graph: {
        legend:{},
        xAxis: {
            type: 'category',
            data: ['Tiempos']
        },
        yAxis: {
            type: 'value'
        },
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b} : {c}'
        },
        toolbox: {
          showTitle:false,
          feature: {
            magicType: {
              title:'',
              type: ['stack', 'tiled']
            },
            dataView: {
              show: true,
              readOnly: true,
              title: 'Ver datos',
              lang: ['', 'Salir', '']
            }
          }
        },
        label:{
          show: true,
          position:'inside',
          formatter: '{a}:{@score}'
        },
        series:[]
      },
      tableName:'',
      tableColumns:[],
		  tableRows:[]
    }
  },
  watch: {
    dataToShowInGraph: function (val) {
      if(Object.keys(val.data).length > 0){
        this.showNodata=false
        this.key_graph_two+= 1
        this.graph['series']= val.data
        this.showGraphics=true
        this.showData=true
      }else{
        this.showNodata=true
        this.showGraphics=false
      }
    },
  },
  methods:{
    loadAllProjects(){
      axios.get('/todos-los-proyectos')
      .then(response => {
        this.Projects=response
        this.loadingPage = false
      });
    },
    selectedProject(){
      this.checks=[]
      this.showOptions = true
      this.showProductType=false
      this.showGraphics=false
      this.showUserType=false
      this.showData=false
    },
    showStrutureInformation(){
      this.loadLevelsOfStructure()
      this.showProductType=true
      this.showFrecuencyType=false
      this.showUserType=false
    },
    showUsers(){
      this.loadUsers()
      this.showUserType=true
      this.showFrecuencyType=false
      this.showProductType=false
    },
    loadUsers(page = 1) {
      let me =this
      axios.get('/usuarios-del-proyecto-con-tareas/',{
        params: {
          project_id: me.projectPickedId,
          page: page
        }
      })
      .then(response => {
        me.Users = response.data;
      });
    },
    loadLevelsOfStructure(){
      let me = this
      axios.get('/estructura/lista-niveles/'+ me.projectPickedId)
      .then(response => {
        me.Levels = response.data; //get all catalogs from category selected
      });
    },
    selectByLevel(){
      let me = this
      axios.get('/grafica/tiempos/nivel/', {
        params: {
          project_id: me.projectPickedId,
          level: me.levelPicked
        }
      })
      .then(response => {
        this.tipo = "Cálculo de tiempos de ajuste por nivel: "+me.levelPicked
        this.dataToShowInGraph =  response.data
      });
    },
    getUserData(user){
      let me = this
      axios.get('/grafica/tiempos/usuario/', {
        params: {
          project_id: me.projectPickedId,
          user_id: user.id
        }
      })
      .then(response => {
        this.tipo = "Cálculo de tiempos usuario: "+user.name
        this.dataToShowInGraph =  response.data
      });
    },
  },
  mounted(){
    this.loadAllProjects()
  }
}
</script>

 <style scoped>
 @import url(http://fonts.googleapis.com/icon?family=Material+Icons);
 .chart{
   width: 100%
 }
 </style>
