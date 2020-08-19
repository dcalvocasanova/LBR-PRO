<template>
  <div class="container container-project">
    <div class="col-md-12">
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-products" role="tabpanel" aria-labelledby="pills-products-tab">
          <table class="table">
           <thead>
              <th class="text-center"> Niveles </th>
              <th> Reacionar objetivos por nivel </th>
            </thead>
            <tbody>
                <tr v-for="l in Levels" :key="l.id" >
                  <td>
                    <span v-text="l">:</span>

                  </td>
                  <td>
                    <button class="btn btn-info" @click="showRelatedUsers(l)"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="pills-subproducts" role="tabpanel" aria-labelledby="pills-subproducts-tab">
          <table class="table">
           <thead>
              <th class="text-center">Productos de los sub-procesos registrados </th>
              <th> Acciones </th>
            </thead>
            <tbody>
              <tr v-for="s in Products.subprocess" :key="s.id" >
                <td>
                  <span v-text="s.process"></span>
                  <span v-text="s.product"></span>
                </td>
                <td>
                  <button class="btn btn-info" @click="showRelatedTask(s.product, s.relatedToLevel)"><i class="fas fa-envelope"></i></button>
                </td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="pills-userFunctions" role="tabpanel" aria-labelledby="pills-userFunctions-tab">
          <table class="table">
           <thead>
              <th class="text-center"> Funciones de usuario registrados </th>
              <th> Acciones </th>
            </thead>
            <tbody>
              <tr v-for="f in UserFunctions" :key="f[0]">
                <td>
                  <span v-text="f[2]"></span>
                  <span v-text="f[0]"></span>
                </td>
                <td>
                  <button class="btn btn-info" @click="showRelatedTask(f[0],f[3])"><i class="fas fa-envelope"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal fade" id="TaskNotificator" tabindex="-1" role="dialog" aria labelledby="TaskNotificator-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="TaskNotificator"> Relacionar Usuarios </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="form-group">
                      <table class="table table-hover">
                       <thead>
                          <tr><th>Objetivos de nivel superior</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <select v-model="form.relatedTemplate" class="form-control" @chanche="getUsersInTemplate(form.relatedTemplate)">
                    <option v-for="t in Templates.data" :value="t.id" :key="t.id">{{ t.name }}</option>
                  </select>
                              </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="form-group">
                      <table class="table table-hover">
                       <thead>
                          <tr><th>Seleccionar de la lista de usuarios a notificar</th></tr>
                        </thead>
                        <tbody>
                          <tr v-for="user in Users" :key="user.id" >
                            <td>
                              <input v-model="usersToRelate" type="checkbox"
                                :value="user.id">
                                  {{user.name}}
                              </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="card-body">
                <div class="container-buttons">
                  <button  @click="saveRelation()" class="btn btn-success">Enviar</button>
                  <button @click="exit()" class="btn btn-secondary">Salir</button>
                </div>
              </div>
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
        form: new Form ({
          title:"Aprobación de tareas",
          body:'',
          project_id: '',
          relatedToLevel:'',
		  relatedTemplate:'',
          usersToNotify:[],
		  usersToRelate:'',
          tasksToNotify:[]
        }),
        tasks: new Form({
          tasks:[]
        }),
        currentProject:0,
        relatedToLevel:'',
		usersToRelate:[],
        usersToNotify:[],
        tasksToNotify:[],
        msg:[],
        Users:{},
        UserFunctions:{},
        Products:{},
        allocator:"",
        Tasks:{},

		 //////

		 Templates:{},
		 Levels:{}
      }
  },
  methods:{
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
          me.currentProject = response.data.id
          me.form.project_id = me.currentProject
		  me.LoadLevelsOfStructure()
          me.getUserFunctions()
          me.getProducts()
      });
    },

	/////////////////////////////////////////////////////////// TemplatesUser
	LoadLevelsOfStructure() {
      let me = this
      axios.get('/estructura/lista-niveles/'+this.currentProject)
      .then(response => {
            me.Levels = response.data; //get all catalogs from category selected
      });
    },
	showRelatedUsers(level){
      this.relatedToLevel = level
      this.getTemplates()
    },
	getTemplates(page = 1){
      let me =this;
      var url = '/plantillas/buscarxtipo/workload';
      axios.get(url + '?page=' + page)
      .then(response => {
        me.Templates = response.data; //get all parameters in DB
		me.form.relatedTemplate = "h";  
        //me.showParameters = true; //Show parameters
		me.getUsersInLevel(me.relatedToLevel)
      })
      .catch(function (error) {
        console.log(error);
      });
    },
	/////////////////////////////////////
    getUserFunctions() {
      axios.get('/estructura/lista-funciones-de-usuario/'+this.currentProject)
      .then(response => {
          this.UserFunctions = response.data; //get all projects from page.
      });
    },
    getProducts() {
      axios.get('/proyecto/productos/'+this.currentProject)
      .then(response => {
          this.Products = response.data; //get all projects from page.
      });
    },
    showRelatedTask(allocator, level){
      this.allocator = allocator
      this.relatedToLevel = level
      this.getTasks()
    },
    getTasks(page = 1) {
      let me =this;
      axios.get('/tareas-por-tipo',{
        params:{
          type: me.type,
          allocator: me.allocator,
          id: me.currentProject,
          page: page
        }
      })
      .then(response => {
        me.Tasks = response.data
        me.getUsersInLevel(me.Tasks.data[0].relatedToLevel)
      });
    },
    loadNotificator(task){
      let me =this;
      $('#TaskNotificator').modal('show')
    },
    getUsersInLevel(level){
      axios.get('/usuarios-por-nivel', {
          params: {
            project: this.currentProject,
            level: level
          }
      })
      .then(response => {
        this.Users = response.data; //get all projects from page
        $('#TaskNotificator').modal('show');
      });
    },
	getUsersInTemplate(template){
		let me =this;
      axios.get('/usuarios-por-template', {
          params: {
            project: this.currentProject,
            template: template,
			level:me.relatedToLevel
          }
      })
      .then(response => {
        this.usersToRelate = response.data; //get all projects from page
        //$('#TaskNotificator').modal('show');
      });
    },

	saveRelation(){
		let me = this
        me.form.relatedToLevel = me.relatedToLevel
        me.form.project_id = me.currentProject
		me.form.usersToRelate = me.usersToRelate.join()
        me.form.post('/relate/users')
        .then(function (response) {
         // me.changeTaskStatus()
          toast.fire({
           type: 'success',
           title: 'Notificación enviada con éxito'
          });
        })
        me.exit()
    },

    sendNotification(){
      let me = this
      if(me.usersToNotify.length > 0 &&  me.tasksToNotify.length > 0){
        me.form.usersToNotify = me.usersToNotify
        me.form.tasksToNotify = me.tasksToNotify.join()
        me.form.body = me.msg.join()
        me.form.relatedToLevel = me.relatedToLevel
        me.form.project_id = me.currentProject
        me.form.post('/notify/task')
        .then(function (response) {
          me.changeTaskStatus()
          toast.fire({
           type: 'success',
           title: 'Notificación enviada con éxito'
          });
        })
        me.exit()
      }
      else
      {
        swal.fire('Error','Debe seleccionar usuarios y tareas a notificar','error')
      }
    },
    changeTaskStatus(){
      let me = this
      me.tasks.tasks = me.tasksToNotify
      console.log(me.tasks.tasks)
      me.tasks.post('/tareas/notificadas')
      .then(function (response) {
        console.log(response.data)
        me.tasksToNotify = []
      })
    },
    tasksToMail(task){
      this.msg.push(task.task);
    },
    exit(){
        $('#TaskNotificator').modal('toggle');
        this.form.reset()
        this.msg =[]
        this.usersToNotify =[]
    }
  },
  mounted() {
    this.getCurrentProject()
  }
}
</script>
