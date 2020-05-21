<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddTasks === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se gestionaran las tareas y procedimientos asociados</h4>
        </div>
        <div class="card-body">
          <div class="form-group">
            <br>
            <select v-model="currentProject" class="form-control" @change="setProject()">
              <option v-for="p in Projects" :value="p.id">{{ p.name }}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-if="this.selectingProjectToAddTasks === false">
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
                      :Correlation="Correlation"
                      :AddedValue="AddedValue"
                      :Risk="Risk"
                      :RiskCondition="RiskCondition"
                      :OrganizationalSkills="OrganizationalSkills"
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
  </div>
</template>

<script>
  export default {
      data(){
        return{
          selectingProjectToAddTasks: true,
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
          RiskCondition:{},
          OrganizationalSkills:{},
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
        setProject(){
          let me = this
          me.selectingProjectToAddTasks=false
          me.getTasks()
          me.LoadLevelsOfStructure()
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
        LoadCatalogRisk() {
          axios.get('catalogo?id=RISK-T')
          .then(response => {
                this.Risk = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogRiskCondition() {
          axios.get('catalogo?id=RISK-CONDITION-T')
          .then(response => {
                this.RiskCondition = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogOrganizationalSkills() {
          axios.get('catalogo?id=ORGANIZATIONAL-SKILL-T')
          .then(response => {
                this.OrganizationalSkills = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogSpecificSkills() {
          axios.get('catalogo?id=SPECIFIC-SKILL-T')
          .then(response => {
                this.SpecificSkills = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogTecnicalSkills() {
          axios.get('catalogo?id=TECNICAL-SKILL-T')
          .then(response => {
                this.TecnicalSkills = response.data; //get all catalogs from category selected
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
        this.getProjects()
        this.LoadCatalogFrecuency();
        this.LoadCatalogWorkType();
        this.LoadCatalogAddedValued()
        this.LoadCatalogCorrelation()
        this.LoadCatalogRisk()
        this.LoadCatalogRiskCondition()
        this.LoadCatalogOrganizationalSkills()
        this.LoadCatalogSpecificSkills()
        this.LoadCatalogTecnicalSkills()
      }
}
</script>
