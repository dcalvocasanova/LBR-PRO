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
              <div class="lbpradio-danger">
                  <input @click="showFrecuencies" type="radio" name="radio" id="radio3"  v-model="checks[2]" value="2" />
                  <label for="radio3">Frecuencia</label>
              </div>
              <div class="lbpradio-danger">
                  <input @click="showDataFrecuencies" type="radio" name="radio" id="radio4"  v-model="checks[3]" value="3" />
                  <label for="radio4">Ver tabla</label>
              </div>
          </div>
        </div>
        <div class="col-md-4" v-if="showProductType">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label class="bmd-label-floating">Por producto</label>
                <select @change="selectByProduct" v-model="productPicked"  id="productPicker" class=" form-control">
                  <option  value="USER-FUNCTION" > Función de usuario</option>
                  <option  value="PRODUCT" > Productos de procesos</option>
                  <option  value="SUB-PRODUCT" > Productos de subproceso</option>
                </select>
              </div>
            </div>
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
        <div class="col-md-4" v-if="showFrecuencyType">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label class="bmd-label-floating">Por frecuencia</label>
                <select @change="selectByFrecuency" v-model="frecuencyPicked"  id="frecuencyPicker" class=" form-control">
                  <option v-for="f in Frecuencies" :key="f.id" :value="f.name"> {{ f.name }}</option>
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
      <v-chart :options="graph_one"  class="chart"/>
    </div>
    <div class="col-12" v-if="showGraphics">
      <v-chart :options="graph_two" :key="key_graph_two" class="chart"/>
    </div>
    <div class="col-12" v-if="showData">
      <datatable
      	:title="tableName"
        :printable="false"
      	:columns="tableColumns"
      	:rows="tableRows"
        :perPage="[10,15,20,25]"
        locale="es"
      />
    </div>
  </div>
</div>
</template>

<script>
import ECharts from 'vue-echarts'
import DataTable from 'vue-materialize-datatable'
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
    'datatable': DataTable,
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
      graph_one: {
        title: {
          text: ' ',
          left: 'center',
          top : 0,
          textStyle: {
            fontSize: 25
          }
        },
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
          top: 40,
          orient: 'vertical',
          right: 0,
          data: []
        },
        toolbox: {
          right: 10,
          show: false,
          feature: {
            dataView: {
              show: true,
              readOnly: true,
              title: 'Ver datos',
              lang: ['', 'Salir', '']
            },
            saveAsImage: {
              show:true,
              title: 'Guardar imagen'
            }
          }
       },
        series: [
          {
            label: {
              position: 'outside',
              formatter: '{b}: {c} ({d}%)'
            },
            top: 35,
            right: 55,
            name: '',
            type: 'pie',
            radius: '80%',
            data:[],
          }]
      },
      graph_two: {
        xAxis: {
            type: 'category',
            data: ['Frecuencias']
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
        this.graph_one['title']['text'] = this.tipo
        this.graph_one['series'][0]['data'] = val.data
        this.graph_one['series'][0]['name'] = this.tipo
        this.graph_one['toolbox']['show'] = true
        this.graph_one['toolbox']['feature']['dataView']['lang'][0] = this.tipo
        this.graph_one['legend']['data'] = val.legend
        this.key_graph_two+= 1
        this.graph_two['series']= val.second_graphic
        this.showGraphics=true
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
      this.showData=false
    },
    showStrutureInformation(){
      this.loadLevelsOfStructure()
      this.showProductType=true
      this.showFrecuencyType=false
      this.showUserType=false
    },
    showFrecuencies(){
      this.loadCatalogFrecuency()
      this.showFrecuencyType=true
      this.showProductType=false
      this.showUserType=false
    },
    showUsers(){
      this.loadUsers()
      this.showUserType=true
      this.showFrecuencyType=false
      this.showProductType=false
    },
    showDataFrecuencies(){
      this.getTableData()
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
    loadCatalogFrecuency(){
      axios.get('/catalogo?id=FRECUENCY')
      .then(response => {
        this.Frecuencies = response.data;
      });
    },
    selectByProduct(){
      let me = this
      axios.get('/grafica/frecuencias/productos/', {
        params: {
          project_id: me.projectPickedId,
          product: me.productPicked
        }
      })
      .then(response => {
        let product = ''
        if(me.productPicked == "USER-FUNCTION") {product = 'funciones de usuario'}
        if(me.productPicked == "PRODUCT") {product = 'productos de proceso'}
        if(me.productPicked == "SUB-PRODUCT") {product = 'productos de sub-proceso'}
        this.tipo = "Frecuencias por "+product
        this.dataToShowInGraph =  response.data
      });
    },
    selectByLevel(){
      let me = this
      axios.get('/grafica/frecuencias/niveles/', {
        params: {
          project_id: me.projectPickedId,
          level: me.levelPicked
        }
      })
      .then(response => {
        this.tipo = "Frecuencias por nivel: "+me.levelPicked
        this.dataToShowInGraph =  response.data
      });
    },
    selectByFrecuency(){
      let me = this
      axios.get('/grafica/frecuencias/frecuencias/', {
        params: {
          project_id: me.projectPickedId,
          frecuency: me.frecuencyPicked
        }
      })
      .then(response => {
        this.tipo = "Tareas por frecuencia: "+me.frecuencyPicked
        this.dataToShowInGraph =  response.data
      });
    },
    getUserData(user){
      let me = this
      axios.get('/grafica/frecuencias/usuario/', {
        params: {
          user_id: user.id
        }
      })
      .then(response => {
        this.tipo = "Tareas por usuario: "+user.name
        this.dataToShowInGraph =  response.data
      });
    },
    getTableData(){
      let me = this
      axios.get('/grafica/frecuencias/datos/', {
        params: {
          project_id: me.projectPickedId
        }
      })
      .then(response => {
        if(Object.keys(response.data.content).length > 0){
          this.showNodata=false
          this.tableName = "Datos de usuarios, tareas y frecuencias"
          this.tableColumns = response.data.title
          this.tableRows =response.data.content
          this.showData=true
        }else{
          this.showNodata=true
          this.showData=false
        }

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

 .lbpradio div {
  clear: both;
  overflow: hidden;
}

.lbpradio label {
  width: 100%;
  border-radius: 3px;
  border: 1px solid #D1D3D4;
  font-weight: normal;
}

.lbpradio input[type="radio"]:empty,
.lbpradio input[type="checkbox"]:empty {
  display: none;
}

.lbpradio input[type="radio"]:empty ~ label,
.lbpradio input[type="checkbox"]:empty ~ label {
  position: relative;
  line-height: 2.5em;
  text-indent: 3.25em;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.lbpradio input[type="radio"]:empty ~ label:before,
.lbpradio input[type="checkbox"]:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  width: 2.5em;
  background: #D1D3D4;
  border-radius: 3px 0 0 3px;
}

.lbpradio input[type="radio"]:hover:not(:checked) ~ label,
.lbpradio input[type="checkbox"]:hover:not(:checked) ~ label {
  color: #888;
}

.lbpradio input[type="radio"]:hover:not(:checked) ~ label:before,
.lbpradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #C2C2C2;
}

.lbpradio input[type="radio"]:checked ~ label,
.lbpradio input[type="checkbox"]:checked ~ label {
  color: #777;
}

.lbpradio input[type="radio"]:checked ~ label:before,
.lbpradio input[type="checkbox"]:checked ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #333;
  background-color: #ccc;
}

.lbpradio input[type="radio"]:focus ~ label:before,
.lbpradio input[type="checkbox"]:focus ~ label:before {
  box-shadow: 0 0 0 3px #999;
}

.lbpradio-default input[type="radio"]:checked ~ label:before,
.lbpradio-default input[type="checkbox"]:checked ~ label:before {
  color: #333;
  background-color: #ccc;
}

.lbpradio-primary input[type="radio"]:checked ~ label:before,
.lbpradio-primary input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #337ab7;
}

.lbpradio-success input[type="radio"]:checked ~ label:before,
.lbpradio-success input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5cb85c;
}

.lbpradio-danger input[type="radio"]:checked ~ label:before,
.lbpradio-danger input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #d9534f;
}

.lbpradio-warning input[type="radio"]:checked ~ label:before,
.lbpradio-warning input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #f0ad4e;
}

.lbpradio-info input[type="radio"]:checked ~ label:before,
.lbpradio-info input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5bc0de;
}

 </style>
