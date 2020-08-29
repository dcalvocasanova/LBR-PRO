<template>
<div>
  <loader :active="loadingPage" spinner="bar-fade-scale" size="90"/>
  <div class="container container-project">
    <div class="col-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="bmd-label-floating">Proyecto</label>
            <select @change="selectedProject" v-model="projectPickedId" class=" form-control">
              <option v-for="p in Projects.data" :value="p.id">{{ p.name }}</option>
            </select>
          </div>
        </div>
        <div class="col-md-4 mt-4" v-if="showOptions">
          <button @click="loadInformation()"type="button" class="btn btn-primary btn-lg btn-block">Descargar archivo</button>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-12" v-if="showNodata">
        <h2 class="text-center">No hay datos para presentar</h2>
      </div>
    </div>
  </div>
  <div class="col-12" v-if="showData">
    <datatable
      :title="tableName"
      :printable="false"
      :columns="tableColumns"
      :rows="tableRows"
      :perPage="[10,20,30]"
      locale="es"
    />
  </div>
</div>
</template>

<script>
import DataTable from 'vue-materialize-datatable'
import VueElementLoading from 'vue-element-loading'


export default {
  components: {
    'datatable': DataTable,
    'loader': VueElementLoading
  },
  data() {
    return{
      Projects:{},
      projectPickedId:0,
      showOptions:false,
      showData:false,
      showGraphics:false,
      showNodata:false,
      loadingPage:true,
      ready: false,
      data:{},
      tableName:'',
      tableColumns:[],
		  tableRows:[]
    }
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
      this.showOptions = true
      this.showData=false
    },
    loadInformation(){
      let me = this
      axios.get('/reporte/tareas-proyecto', {
        params: {
          project_id: me.projectPickedId
        }
      })
      .then(response => {
        me.data=response.data
        if(Object.keys(me.data.content).length > 0){
          this.showNodata=false
          this.tableName = "Datos de usuarios y tareas del proyecto"
          this.tableColumns = me.data.title
          this.tableRows = me.data.content
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
