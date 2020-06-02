<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectBeforeReport === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se mostrará el reporte de tareas comunicadas</h4>
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
    <div class="row" v-if="this.selectingProjectBeforeReport === false">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Tareas registrados en la estructura de niveles</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre del nivel </th>
                      <th> Tarea </th>
                      <th> Se envió a notificar </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="task in Task.data" :key="task.id">
                        <td v-text="task.relatedToLevel"></td>
                        <td v-text="task.task"></td>
                        <td v-html="getIcon(task.notified)"></td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="footer">
              <pagination :data="Task" @pagination-change-page="getTasks"></pagination>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Registro de aprobación</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre del nivel </th>
                      <th> Estado </th>
                      <th> Detalles </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="gn in GoalsNotified" :key="gn.id">
                        <td v-text="gn.relatedToLevel"></td>
                        <td v-html="getStatus(gn.status)"></td>
                        <td>
                          <button class="btn btn-info" @click="getInformation(gn)"><i class="fas fa-info"></i></button>
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

    <div class="modal fade" id="notificationDetails" tabindex="-1" role="dialog" aria-labelledby="notificationDetails-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h3 class="modal-title" id="notificationDetails">Detalles</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="jumbotron jumbotron-fluid">
              <div class="container">
                <h3 class="display-5" v-text="currentAlert.title"></h3>
                <p class="lead" v-html="currentAlert.body"></p>
              </div>
              <div class="row">
                <div class="col-md-6 text-center">
                  <h4> Enviado a <span class="badge badge-info" v-text="user.name"></span></h4>

                </div>
                <div class="col-md-6 text-center">
                  <h4><span class="badge badge-light">
                    <time-ago :datetime="currentAlert.created_at" refresh locale="es" long></time-ago>
                  </span></h4>
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
import TimeAgo from "vue2-timeago";
export default {
  components: {
    TimeAgo
  },
  data(){
    return{
      selectingProjectBeforeReport:true,
      currentProject:0,
      currentAlert:{},
      Projects:{},
      Goals:[],
      Task:{},
      user:{},
      GoalsNotified:[]
    }
  },
  methods:{
    LoadNotificationGoals() {
      let me = this
      axios.get('/notificaciones/objetivos/'+me.currentProject)
      .then(response => {
            me.GoalsNotified = response.data; //get all catalogs from category selected
      });
    },
    getTasks(page = 1) {
      let me =this;
      axios.get('/tareas/'+this.currentProject+'?page=' + page)
      .then(response => {
        me.Task = response.data
      });
    },
    getIcon(condition){
      if(condition){
        return '<i class="fas fa-check" aria-hidden="true"></i>'
      }else{
        return '<i class="fa fa-times" aria-hidden="true"></i>'
      }
    },
    LoadGoals() {
      let me = this
      axios.get('/estructura/lista-objetivos/'+me.currentProject)
      .then(response => {
            me.Goals = response.data; //get all catalogs from category selected
      });
    },
    setProject(){
      let me = this
      me.selectingProjectBeforeReport=false
      me.getTasks()
      me.LoadNotificationGoals()
      me.LoadGoals()
    },
    getStatus(status){
      if (status === "Pending"){return "Notificación pendiente de aprobación"}
      if (status === "Acepted"){return "Notificación aceptada"}
      if (status === "Rejected"){return "Notificación rechazada"}
      if (status === "Correcting"){return "Notificación proceso de subsane"}
      if (status === "Corrected"){return"Notificación ya subsanada"}
    },
    getInformation(alerting){
      this.getUsuario(alerting.receiver)
      this.currentAlert= alerting
      $('#notificationDetails').modal('show')
    },
    getUsuario(id){
      let me =this;
      axios.get('/usuarios/buscar/'+id)
      .then(response => {
            me.user = response.data; //get all projects from page
      });
    },
    getProjectos(){
      let me =this;
      axios.get('/todos-los-proyectos')
      .then(response => {
            me.Projects = response.data; //get all projects from page
      });
    }
  },
  mounted() {
   this.getProjectos()
  }
}
</script>
