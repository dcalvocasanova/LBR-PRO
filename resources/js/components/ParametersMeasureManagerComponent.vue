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
                  <tr><th> Categoría </th></tr>
                </thead>
                <tbody>
                  
                    <parameter-measure
                    :template="Templates"
                    >
                   </parameter-measure>
            
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <pagination :data="Templates" @pagination-change-page="getUserTemplates"></pagination>
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
	/////////////////////////////////////	
	  Templates:[]
		
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
	  me.getUserTemplates();
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
	  
	getUserTemplates(page = 1) {
      let me =this;
      axios.get('/plantillas/porusuario',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.Templates = response.data
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
     // me.LoadLevelsOfStructure()
    },

  },
  mounted() {
    this.getCurrentProject()

  }
}
</script>
