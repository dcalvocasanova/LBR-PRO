<template>
  <div class="container container-project">
    <div class="card card-plain">
      <div class="card-header card-header-primary">
        <h4 class="card-title mt-0">Niveles de estructura del proyecto</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <p>
            A continuación se muestran los niveles de estructura del proyecto,
            para enviar la solicitud de aprobación de los objetivos sólo de clic en el
            área o departamento a notificar
          </p>
        </div>
        <div class="row">
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
      <div class="card-footer">
        <button @click="saveLevel()" class="btn btn-success" data-dismiss="modal" aria-label="Close">Salir</button>
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
      Levels:{}, // All levels from organization
      currentProject:0,
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
      this.getUsers(item)
      if(this.justShowTree){
        $('#NotificatorManager').modal('show')
        this.currentNode = item
      }
    },
    getUsers(item){
      axios.get('/usuarios-jefes-por-nivel',{
        params:{
          project: this.currentProject,
          level: item.name
        }
      })
      .then(response => {
        this.Users = response.data; //get current user
      });
    },
    getLevels(){
      let me =this;
      let url = '/estructura?id='+me.currentProject;
      axios.get(url).then(function (response) {
        me.Levels = JSON.parse(response.data.levels); //get all structure
        me.level.id= response.data.id;
        me.level.project_id=me.currentProject;
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
    },
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.currentProject = response.data.id
        me.getLevels()
      });
    }
  },
  mounted() {
    this.getCurrentProject();
  }
}
</script>

<style>
.modal-body {
  max-height: calc(100vh - 160px);
  overflow-y: auto;
}
</style>
