<template>
  <div class="container container-project">
    
    <div class="row">
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
                    :jornada ="jornada"
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
      currentProject:"",
      currentUser:"",
      Projects:{},
      Tasks:{},	
	  Templates:{}
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
     // me.selectingProjectToAddTasks=false
      me.getTasks()
     // me.LoadLevelsOfStructure()
    },

  },
  mounted() {
    this.getCurrentProject()

  }
}
</script>
