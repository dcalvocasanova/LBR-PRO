<template>
  <div class="container container-project">
    <div class="col-md-12">
      <div class="card card-plain">
        <div class="card-header card-header-primary">
          <div class="text-center">
            <h5 class="card-title mt-1"> Lista de tareas</h5>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Por producto</label>
                    <select @change="getTasks" v-model="type" class=" form-control">
                      <option  value="USER-FUNCTION"> Función de usuario</option>
                      <option  value="PRODUCT"> Producto</option>
                      <option  value="SUB-PRODUCT"> Producto de Subproceso</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Por nivel</label>
                    <select @change="getTasks" v-model="level" class=" form-control">
                      <option v-for="l in Levels" :value="l">{{ l }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <input type="checkbox" v-model="tiempos"/>
              <label>Mostrar tiempos</label><br>
              <input type="checkbox" v-model="mejoramiento"/>
              <label>Mejoramiento</label>
            </div>
          </div>
        </div>
        <div class="card-body ">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr><th> Tarea </th></tr>
              </thead>
              <tbody>
                <tr v-for="t in Tasks.data" :key="t.id">
                  <tasks-unit
                  :task="t"
                  :showTimeOption="tiempos"
                  :showImproveOption="mejoramiento"
                  :Frecuencies="Frecuencies"
                  :WorkTypes="WorkTypes"
                  :PHVA="PHVA"
                  :Correlation="Correlation"
                  :AddedValue="AddedValue"
                  :Risk="Risk"
                  :Effort="Effort"
                  :Skills="Skills"
                  >
                </tasks-unit>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
        <div class="card-footer">
          <pagination :data="Tasks" @pagination-change-page="getTasks"></pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      selectingProjectToAddTasks: false,
      tiempos:true,
      mejoramiento:false,
      currentProject:0,
      Projects:{},
      Tasks:{},
      TaskElements:{},
      PHVA:{},
      Frecuencies:{},
      WorkTypes:{},
      AddedValue:{},
      Correlation:{},
      Risk:{},
      Effort:{},
      Skills:{},
      Levels:{},
      level:"",
      type:"",
    }
  },
  methods:{
    getProjects(){
      let me =this;
      axios.get('/todos-los-proyectos')
      .then(response => {
        me.Projects = response.data; //get all projects from page
      });
    },
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.currentProject = response.data.id
        me.getTasks()
        me.LoadLevelsOfStructure()
      });
    },
    getTasks(page = 1) {
      let me =this;
      axios.get('/tareas-por-tipo',{
        params:{
          level: me.level,
          type: me.type,
          id: me.currentProject,
          page: page
        }
      })
      .then(response => {
        me.Tasks = response.data
      });
    },
    LoadCatalogFrecuency() {
      axios.get('catalogo?id=FRECUENCY')
      .then(response => {
        this.Frecuencies = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogWorkType() {
      axios.get('catalogo?id=WORKTYPE')
      .then(response => {
        this.WorkTypes = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogAddedValued() {
      axios.get('catalogo?id=ADDED-VALUED-T')
      .then(response => {
        this.AddedValue = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogCorrelation() {
      axios.get('catalogo?id=CORRELATION-T')
      .then(response => {
        this.Correlation = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogEfforts() {
      axios.get('catalogo?id=EFFORT-T')
      .then(response => {
        this.Effort = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogPHVA() {
      axios.get('/catalogo/phva')
      .then(response => {
        this.PHVA = response.data; 
      });
    },
    LoadCatalogSkills() {
      axios.get('catalogo/competencias')
      .then(response => {
        this.Skills = response.data;
      });
    },
    LoadCatalogRisk() {
      axios.get('catalogo/riesgos')
      .then(response => {
        this.Risk = response.data;
      });
    },
    LoadLevelsOfStructure() {
      let me = this
      axios.get('/estructura/lista-niveles/'+me.currentProject)
      .then(response => {
        me.Levels = response.data; //get all catalogs from category selected
      });
    }
  },
  mounted() {
    this.getCurrentProject()
    this.LoadCatalogFrecuency();
    this.LoadCatalogPHVA();
    this.LoadCatalogWorkType();
    this.LoadCatalogAddedValued()
    this.LoadCatalogCorrelation()
    this.LoadCatalogRisk()
    this.LoadCatalogSkills()
    this.LoadCatalogEfforts()
  }
}
</script>
