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
	<div class="row">
      <div class="col-md-4 text-center">
		<button type="button" class="btn btn-outline-info btn-lg " disabled>Identificación: {{currentUserData.identification}}</button>
		<button type="button" class="btn btn-outline-info btn-lg " disabled>Nombre: {{currentUserData.name}}</button>
        <button type="button" class="btn btn-outline-info btn-lg " disabled>Jordada: {{workday}} min</button>
		<button type="button" class="btn btn-outline-info btn-lg " disabled>Puesto: {{currentUserData.position}}</button>
		<button type="button" class="btn btn-outline-info btn-lg " disabled>Nivel: {{currentUserData.relatedLevel}}</button>
		<button type="button" class="btn btn-outline-info btn-lg " disabled>Tiempo utilizado:{{tiempoUtilizado}} min</button>
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
	  workday:"",
	  tiempoUtilizado:0,
	  currentUserData:{}
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
        me.getCurrentUser()
       // me.LoadLevelsOfStructure()

      });
    },
	getCurrentUser(){
      let me =this;
      axios.get('/usuario')
      .then(response => {
      me.currentUser = response.data.id
	  me.currentUserData = response.data
	  me.getUserTasks();
	  me.getWorday();
	  me.getUserTime();
	  me.getParametersTime();
      });
    },
	getUserTasks(page = 1) {
      let me =this;
      axios.get('/tareas-por-usuario',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.Tasks = response.data 	  
      });
    },
	getWorday(){
		 let me =this;
      axios.get('/usuarios/workday',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.workday = response.data
		me.getExtendWorkday()
      });
	},
	getUserTime(){
		 let me =this;
      axios.get('/measures/tiempo',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.tiempoUtilizado += response.data
      });
	},
	getParametersTime(){
		 let me =this;
      axios.get('/parameter_measures/tiempo',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.tiempoUtilizado += response.data
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
	getExtendWorkday() {
      let me =this;
      axios.get('measure/jornada-extendida',{
        params:{
          relatedToLevel: me.level,
		  project_id: me.currentProject,
		 
        }
      })
      .then(response => {
        me.workday = parseInt(me.workday) + parseInt(response.data.extend)
      });
    },
    setProject(){
      let me = this
      me.selectingProjectToAddTasks=false
      me.getTasks()
    },

  },
  mounted() {
    this.getCurrentProject()
  }
}
</script>
