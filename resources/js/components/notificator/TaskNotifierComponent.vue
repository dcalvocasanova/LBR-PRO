<template>
  <div class="container container-project">
    <div class="col-md-12">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-products-tab" data-toggle="pill" href="#pills-products" role="tab" aria-controls="pills-products" aria-selected="true">Productos</a>
        </li>
        <li class="nav-item">
          <a  class="nav-link" id="pills-subproducts-tab" data-toggle="pill" href="#pills-subproducts" role="tab" aria-controls="pills-subproducts" aria-selected="false">Productos de subprocesos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-userFunctions-tab" data-toggle="pill" href="#pills-userFunctions" role="tab" aria-controls="pills-userFunctions" aria-selected="false">Funciones de usuario</a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-products" role="tabpanel" aria-labelledby="pills-products-tab">
          <table class="table">
           <thead>
              <th class="text-center"> Productos de los procesos registrados </th>
              <th> Enviar notificación </th>
            </thead>
            <tbody>
                <tr v-for="p in Products.process" :key="p.id" >
                  <td>
                    <span v-text="p.file">:</span>
                    <span v-text="p.resultProduct"></span>
                  </td>
                  <td>
                    <button class="btn btn-info" @click="showRelatedTask(p.resultProduct, p.relatedToLevel)"><i class="fas fa-envelope"></i></button>
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
                  <button class="btn btn-info" @click="showRelatedTask(f[0],f[2])"><i class="fas fa-envelope"></i></button>
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
            <h5 class="modal-title" id="TaskNotificator"> Enviar notificación de aprobación de tareas </h5>
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
                          <tr><th>Seleccionar de la lista de tarea</th></tr>
                        </thead>
                        <tbody>
                          <tr v-for="task in Tasks.data" :key="task.id" >
                            <td>
                              <input v-model="tasksToNotify" @click="tasksToMail(task)" type="checkbox"
                                :value="task.id">
                                  {{task.task}}
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
                              <input v-model="usersToNotify" type="checkbox"
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
                  <button  @click="sendNotification()" class="btn btn-success">Enviar</button>
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
          usersToNotify:[],
          tasksToNotify:[]
        }),
        tasks: new Form({
          tasks:[]
        }),
        currentProject:0,
        relatedToLevel:'',
        usersToNotify:[],
        tasksToNotify:[],
        msg:[],
        Users:{},
        UserFunctions:{},
        Products:{},
        allocator:"",
        Tasks:{}
      }
  },
  methods:{
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
          me.currentProject = response.data.id
          me.form.project_id = me.currentProject
          me.getUserFunctions()
          me.getProducts()
      });
    },
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
        if(Object.keys(response.data.data).length > 0){
          me.Tasks = response.data
          me.getUsersInLevel(me.Tasks.data[0].relatedToLevel)
        }else{
          swal.fire('info','Sin tareas registradas','info')
        }
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
      me.tasks.post('/tareas/notificadas')
      .then(function (response) {
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
