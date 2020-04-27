<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0">Proyecto a notificar</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th>Nombre</th>
                    <th>Logo</th>
                    <th>Niveles de estructura</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="project in Projects.data" :key="project.id" >
                    <td v-text="project.name"></td>
                    <td style="width: 80px;"> <img  class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                    <td>
                      <button class="btn btn-primary" @click="loadLevelData(project)" data-toggle="modal" data-target="#addLevels"><i class="fas fa-swatchbook">Niveles de estructura</i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Projects" @pagination-change-page="getProjectsPaginator"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addLevels" tabindex="-1" role="dialog" aria-labelledby="LevelModalOptions-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h2 class="modal-title" @click="saveLevel()" id="LevelModalOptions">Niveles de estructura del proyecto</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-title">
                <p>
                  A continuación se muestran los niveles de estructura del proyecto,
                  para enviar la solicitud de aprobación de los objetivos sólo de clic en el
                  área o departamento a notificar
                </p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="tree-menu">
                    <div class="tree-viewer">
                      <tree-menu
                        class="item" :item="Levels":parent="Levels"
                        :showTreeEditor="showAsStructureEditor"
                        :showGoalEditor="showAsGoalEditor"
                        :justShowTree="justShowTree"
                        @clicked-node="nodoSeleccionado"
                      >
                      </tree-menu>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button @click="saveLevel()" class="btn btn-success" data-dismiss="modal" aria-label="Close">Salir</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="NotificatorManager" tabindex="-4" role="dialog" aria-labelledby="RelatedManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="InheritageManager"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <notificator-goals-cheking
                :Item=currentNode
                :Users=Users
                :Project=currentProject
                @close-modal="salirYNotificar"
                ></notificator-goals-cheking>
              </div>
              <div class="card-footer">
                <div class="container-buttons">
                  <button @click="salirNotificador()" class="btn btn-secondary">Salir</button>
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
	props:{
      showAsStructureEditor: Boolean,
      showAsGoalEditor: Boolean,
      justShowTree: Boolean
    },
    data(){
      return{
        Projects:{}, //All registered projects
        Levels:{}, // All levels from organization
        currentProject:{}, //Current
        Users:[],
        Lista:[],
        currentNode: {}, //Current node to update or add
        level: new Form({
          id:"", //level projectID
          levels:"",
          project_id:""
        })
      }
    },
    methods:{
      nodoSeleccionado(item){
        if (item.notificated) {
          swal.fire(
            'Información','Ya el nivel de la estructura fue notificado, para más información dirijase al panel de notificaciones','info'
          )
        }else{
          this.getUsers(item)
          if(this.justShowTree){
            $('#NotificatorManager').modal('show')
            this.currentNode = item
          }
        }
      },
      getUsers(item){
        axios.get('/usuarios-jefes-por-nivel',{
          params:{
            project: this.currentProject.id,
            level: item.name
          }
        })
        .then(response => {
            this.Users = response.data; //get current user
        });
      },
      getProjectsPaginator(page = 1) {
        axios.get('/proyectos?page=' + page)
        .then(response => {
              this.Projects = response.data; //get all projects from page
        });
      },
      getLogo(project){
        let logo = (project.logo_project.length > 200) ? project.logo_project : "/img/profile-prj/"+ project.logo_project ;
        return logo;
      },
      getProjects(){
        let me =this;
        axios.get('/proyectos').then(function (response) {
            me.Projects = response.data; //get all projects
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      getLevels(){
          let me =this;
          let url = '/estructura?id='+me.currentProject.id;
          axios.get(url).then(function (response) {
              me.Levels = JSON.parse(response.data.levels); //get all structure
              me.level.id= response.data.id;
              me.level.project_id=me.currentProject.id;
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      saveLevel(){
        let me =this
        me.currentNode.notificated =true
        me.level.levels =JSON.stringify(me.Levels)
        me.updateLevel()
      },
      updateLevel(){
          let me = this;
          this.level.put('/estructura/actualizar')
          .then(function (response) {

          })
          .catch(function (error) {
              console.log(error);
          });
      },
      loadLevelData(project){
          this.currentProject= project;
          this.getLevels();
      },
      salirNotificador(){
        $('#NotificatorManager').modal('toggle')
      },
      salirYNotificar(){
        this.saveLevel()
        $('#NotificatorManager').modal('toggle')
      }
    },
    created(){
      Fire.$on('searching',() => {
        let query = this.$parent.search;
        axios.get('/findproject?q=' + query)
        .then((response) => {
            this.Projects = response.data
        })
        .catch(() => {
        })
      })
    },
    mounted() {
     this.getProjects();
    }
  }
</script>

<style>
.modal-body {
    max-height: calc(100vh - 160px);
    overflow-y: auto;
}
</style>
