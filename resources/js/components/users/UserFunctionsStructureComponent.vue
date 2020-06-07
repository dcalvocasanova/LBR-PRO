<template>
  <div class="container container-project">
    <div class="card card-plain">
      <div class="card-header card-header-primary">
        <h4 class="card-title mt-0">Seleccione el nivel para agregar funciones a los usuarios</h4>
      </div>
      <div class="card-body">
        <tree-menu
          class="item" :item="Levels":parent="Levels"
          :showUserFunctionsEditor="showAsUserFunctionsEditor"
          @create-user-function="createUserFunction"
          @modify-user-function="showUserFunctions"
        >
        </tree-menu>
      </div>
      <div class="card-footer">
        <button @click="saveLevel()" class="btn btn-success" data-dismiss="modal" aria-label="Close">Guardar cambios</button>
      </div>
    </div>

    <div class="modal fade" id="UserFunctionsManager" tabindex="-2" role="dialog" aria labelledby="UserFunctionsManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="LevelManager">{{title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-12">
                    <div class="row">
                      <div class="users-and-goals col-md-6">
                        <table class="table table-hover">
                         <thead>
                            <tr><th>Seleccione los objetivos asociados a la tarea</th></tr>
                          </thead>
                          <tbody>
                            <tr v-for="goal in currentNode.goals" :key="goal.pos" >
                              <td>
                                <input v-model="goalsRelatedToUserFunction" type="checkbox"
                                  :name="goal.pos"
                                  :value="goal.pos">
                                    {{goal.name}}
                                </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="user-functions col-md-6">
                        <div class="form-group">
                          <table class="table table-hover">
                           <thead>
                              <tr><th>Seleccione el usuario asociados a la tarea</th></tr>
                            </thead>
                            <tbody>
                              <tr v-for="user in Users" :key="user.id" >
                                <td>
                                  <input v-model="usersRelatedToUserFunction" type="checkbox"
                                    :value="user.id">
                                      {{user.name}}
                                  </td>
                              </tr>
                            </tbody>
                          </table>
                          <label class="bmd-label-floating">Función</label>
                          <input  v-model="functionUserName" type="text" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="container-buttons">
                    <button v-if="update== 0" @click="addUserFunction()" class="btn btn-success">Añadir</button>
                    <button v-if="update!= 0" @click="updateUserFunction()" class="btn btn-info">Actualizar</button>
                    <button @click="exitEditorUserFunctions()" class="btn btn-secondary">Salir sin guardar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ModifyUserFunctionsManager" tabindex="-3" role="dialog" aria-labelledby="ModifyUserFunctionsManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ModifyUserFunctionsManager"> Lista de funciones de usuario del nivel: {{currentNode.name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <table class="table table-hover">
                   <thead>
                      <tr><th>Lista de funciones del nivel</th></tr>
                    </thead>
                    <tbody>
                      <tr v-for="userfunctions in currentNode.userFunctions" :key="userfunctions.name" >
                        <td v-text="userfunctions.name"></td>
                        <td>
                          <button class="btn btn-info" @click="modifyUserFunction(userfunctions)"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger" @click="deleteUserFunction(userfunctions)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                  <div class="container-buttons">
                    <button @click="exitMainViewUserFuntions()" class="btn btn-secondary">salir</button>
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
   props:{
    showAsUserFunctionsEditor: Boolean
   },
   data(){
    return{
      project_id:0,
      update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
      currentNode: {}, //Current node to update or add
      title:"",
      indexToUpdate:0,
      //Catalogs
      Projects:{}, //All registered projects
      Levels:{}, // All levels from organization
      Users:{},
      userFunctions:[],
      //elements inside de userfuntion definition
      usersRelatedToUserFunction:[],
      goalsRelatedToUserFunction:[],
      functionUserName:"",
      //element send to DB
      level: new Form({
        id:"", //level projectID
        levels:"",
        project_id:""
      })
    }
   },
   methods:{
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.project_id = response.data.id
        me.getLevels()
      });
    },
    getLevels(){
      let me =this;
      let url = '/estructura?id='+me.project_id;
      axios.get(url).then(function (response) {
        me.Levels = JSON.parse(response.data.levels); //get all structure
        me.level.id= response.data.id;
        me.level.project_id=response.data.project_id;
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    saveLevel(){
      let me =this
      me.level.levels =JSON.stringify(me.Levels)
      me.updateLevel()
    },
    updateLevel(){
      let me = this;
      this.level.put('/estructura/actualizar')
      .then(function (response) {
         toast.fire({
          type: 'success',
          title: 'Niveles de estructura registrado con éxito'
         });
         me.level.reset()
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    createUserFunction(item){
      let me = this;
      me.currentNode = item
      me.update = 0
      me.title= "Registrar funciones de usuario"
      this.functionUserName = ""
      this.usersRelatedToUserFunction = []
      this.goalsRelatedToUserFunction = []
      this.userFunctions=[]
      me.getUserinLevel(me.currentNode.name);
      me.showUserFuntionEditor()
    },
    showUserFunctions(item){
      let me = this
      me.currentNode = item
      me.showUserFuntionManager()
    },
    modifyUserFunction(item){
      let me = this
      me.update = 1
      me.indexToUpdate=me.currentNode.userFunctions.indexOf(item)
      me.title= "Modificar funciones de usuario"
      me.getUserinLevel(me.currentNode.name);
      me.usersRelatedToUserFunction = item.users
      me.goalsRelatedToUserFunction = item.goals
      me.functionUserName= item.name
      me.exitMainViewUserFuntions()
      me.showUserFuntionEditor()
    },
    showUserFuntionEditor(){
      $('#UserFunctionsManager').modal('show')
    },
    showUserFuntionManager(){
      $('#ModifyUserFunctionsManager').modal('show')
    },
    getUserinLevel(level){
      axios.get('/usuarios-por-nivel', {
          params: {
            project: this.project_id,
            level: level
          }
      })
      .then(response => {
        this.Users = response.data; //get all projects from page
      });
    },
    addUserFunction() {
      let me = this;
      if(me.functionUserName.trim()!="" && me.usersRelatedToUserFunction.length >0 && me.goalsRelatedToUserFunction.length >0){
        me.currentNode.userFunctions.push({
          name: me.functionUserName,
          users: me.usersRelatedToUserFunction,
          goals: me.goalsRelatedToUserFunction
        })
        me.exitEditorUserFunctions()
      }else{
        swal.fire(
          'Datos incompletos',
          'Es necesario seleccionar objetivos, usuarios y un nombre para registrar la función de usuario',
          'warning'
        )
      }

    },
    updateUserFunction() {
      let me = this
      if(me.functionUserName.trim()!="" && me.usersRelatedToUserFunction.length >0 && me.goalsRelatedToUserFunction.length >0){
        me.currentNode.userFunctions[me.indexToUpdate].name = me.functionUserName
        me.currentNode.userFunctions[me.indexToUpdate].users = me.usersRelatedToUserFunction
        me.currentNode.userFunctions[me.indexToUpdate].goals = me.goalsRelatedToUserFunction
        me.exitEditorUserFunctions()
      }else{
        swal.fire(
          'Datos incompletos',
          'Es necesario seleccionar objetivos, usuarios y un nombre para registrar la función de usuario',
          'warning'
        )
      }
    },
    deleteUserFunction(item){
      let me = this;
      swal.fire({
        title: 'Eliminar una función de usuario',
        text: "Esta acción no se puede revertir, Está a punto de eliminar una función usuario",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarla!'
      })
      .then((result) => {
        if (result.value) {
          me.currentNode.userFunctions = me.deleteIndex(me.currentNode.userFunctions,item)
          swal.fire(
            'Eliminado',
            'Función de usuario fue eliminada',
            'success'
          )
        }
      })

    },
    deleteIndex(arr, index){
      return arr.filter(function(i){
        return i!= index
      });
    },
    exit(){
      $('#LevelManager').modal('toggle')
      this.updateBackgroundTaskUserFunctions()
    },
    exitEditorUserFunctions(){
      $('#UserFunctionsManager').modal('toggle');
      if(this.update != 0){
        $('#ModifyUserFunctionsManager').modal('show')
      }
      this.updateBackgroundTaskUserFunctions()
    },
    exitMainViewUserFuntions(){
      $('#ModifyUserFunctionsManager').modal('toggle');
      this.updateBackgroundTaskUserFunctions()
    },
    updateBackgroundTaskUserFunctions(){
      let me =this;
      me.level.levels =JSON.stringify(me.Levels)
      this.level.put('/estructura/actualizar')
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
   this.getCurrentProject();
  }
}
</script>

<style>
.modal-body {
    max-height: calc(100vh - 80px);
    overflow-y: auto;
}
</style>
