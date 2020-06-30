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
          <div class="card-body ">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr><th> Tarea </th></tr>
                </thead>
                <tbody>
                  <tr v-for="t in Tasks.data" :key="t.id">
                    <tasks-measure
                    :task="t"
                    :showTimeOption="tiempos"
                    :Frecuencies="Frecuencies"
                    :WorkTypes="WorkTypes"
                    :Correlation="Correlation"
                    :AddedValue="AddedValue"
                    :Risk="Risk"
                    :RiskCondition="RiskCondition"
                    :OrganizationalSkills="OrganizationalSkills"
                    >
                  </tasks-measure>
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
      selectingProjectToAddTasks: false,
      tiempos:true,
      mejoramiento:false,
      currentProject:"",
      currentUser:"",
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
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.currentProject = response.data.id
        me.getTasks()
        //me.LoadLevelsOfStructure()
      });
    },
	getCurrentUser(){
      let me =this;
      axios.get('/usuario')
      .then(response => {
        me.currentUser = response.data.id
      });
    },
	getUserTasks(page = 1) {
      let me =this;
      axios.get('/tareas-por-usuario',{
        params:{
          id: me.getCurrentUser(),

        }
      })
      .then(response => {
        me.Tasks = response.data
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

  },
  mounted() {
    this.getCurrentProject()

  }
}
</script>
