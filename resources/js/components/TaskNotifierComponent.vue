<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddTasks === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se notificaran las tareas</h4>
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
            <div class="col-md-8">
                <h3 class="card-title mt-0"> Lista de tareas</h3>
            </div>
            <div class="col-md-4"
              data-toggle="modal"
              data-target="#TaskNotificator">
              <button class="btn btn-primary">
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="card-body card-body-fitted ">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Tarea </th>
                    <th> enviar notificación </th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="task in Tasks.data" :key="task.id">
                      <td v-text="task.task"></td>
                      <td>
                        <button class="btn btn-info" @click="loadNotificator(task)"><i class="fas fa-edit"></i></button>
                      </td>
                    </tr>
                  </tbody>
              </table>
              <div class="footer">
                <pagination :data="Tasks" @pagination-change-page="getTasks"></pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="TaskNotificator" tabindex="-1" role="dialog" aria labelledby="TaskNotificator-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="TaskNotificator"> Enviar notificación de aprobación de tarea: {{title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-8">
                <div class="card">
                  <div class="card-body">
                    <div class="form-group">
                      <table class="table table-hover">
                       <thead>
                          <tr><th>Seleccione el usuario a notificar la tarea</th></tr>
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
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <div class="container-buttons">
                      <button  @click="saveTask()" class="btn btn-success">Enviar</button>
                      <button @click="clearFields()" class="btn btn-secondary">Salir</button>
                    </div>
                  </div>
                </div>
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
                id:"",
                project_id:"",
                task_id:"",
                procedure:"",
                PHVA:{},
                frecuency:"",
                t_min:"",
                t_avg:"",
                t_max:"",
                laborType:""
              }),
              selectingProjectToAddTasks: true,
              currentProject:0,
              usersToNotify:[],
              Users:{},
              task_id:[],
              title:"", //title to show
              update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
              showVariable:0,
              Projects:{},
              Tasks:{},

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
          axios.get('/tareas/'+this.currentProject+'?page=' + page)
          .then(response => {
            me.Tasks = response.data
          });
        },
        loadNotificator(task){
          let me =this;
          me.getUserinLevel(task.relatedToLevel)
          me.title = task.task
          $('#TaskNotificator').modal('show')
        },
        getUserinLevel(level){
          axios.get('/usuarios-por-nivel', {
              params: {
                project: this.currentProject,
                level: level
              }
          })
          .then(response => {
            this.Users = response.data; //get all projects from page
          });
        },
        setProject(){
          let me = this
          me.selectingProjectToAddTasks=false
          me.getTasks()
          me.getTaskElements()
        },
        getTaskElements(page = 1) {
          let me =this;
          axios.get('/tareas-elementos-asociados/'+this.currentProject+'?page=' + page)
          .then(response => {
            me.TaskElements = response.data
          });
        },
        saveTask(){
          let me =this;
          me.form.project_id=me.currentProject
          let PHVA = JSON.stringify(me.form.PHVA)
          me.form.PHVA = PHVA
          me.form.task_id= me.task_id.toString();
          me.form.post('/tareas-elementos-asociados/guardar')
          .then(function (response) {
              me.clearFields();
              me.getTaskElements();
              toast.fire({
                type: 'success',
                title: 'Elementos de la tarea guardados con éxito'
              });
          });
        },
        showTask(task){
          let me =this;
          me.form.fill(task);
          me.task_id = task.task_id.split(",");
          me.update = task.id
          me.title="Actualizar información de los elementos de las tareas"
          $('#TaskCatalogPicker').modal('show')
        },
        updateTask(task){
          let me = this;
          me.form.task_id= me.task_id.toString();
          me.form.put('/tareas-elementos-asociados/actualizar')
          .then(function (response) {
             toast.fire({
              type: 'success',
              title: 'Elementos de la tarea actualizado con éxito'
             });
             me.getTaskElements();
             me.clearFields();
          })
        },
        deleteTask(task){
          let me =this;
          swal.fire({
            title: 'Eliminar configuración',
            text: "Esta acción no se puede revertir, Está a punto de eliminar elementos de tareas",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#114e7e',
            cancelButtonColor: '#20c9a6',
            confirmButtonText: '¡Sí, eliminarlo!'
          })
          .then((result) => {
            if (result.value) {
              axios.delete('/tareas-elementos-asociados/borrar/'+task.id)
              .then(function (response) {
                swal.fire(
                  'Eliminado',
                  'Configuración fue eliminada',
                  'success'
                )
                me.getTaskElements();
              })
            }
          })
        },
        clearFields(){
          let me =this;
          $('#TaskNotificator').modal('toggle')
          me.title= "";
          me.update = 0
          me.usersToNotify=[]
          me.form.reset()
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
        }
      },
      mounted() {
        this.getProjects()
        this.LoadCatalogFrecuency();
        this.LoadCatalogWorkType();
      }
}
</script>
