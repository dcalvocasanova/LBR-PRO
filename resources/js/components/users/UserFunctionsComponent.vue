<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Usuarios en la plataforma</h4>
          </div>
            <div class="card-body">
            <div class="col-12">
              <div class="form-group">
                <label class="bmd-label-floating">Proyecto base</label>
                <select @change="getUsuarios()" v-model="currentProject" class=" form-control">
                  <option v-for="p in Projects" :value="p.id">{{ p.name }}</option>
                </select>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Nombre </th>
                    <th> Puesto </th>
                    <th> Agregar o moficar funciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr  v-for="user in Users.data" :key="user.id">
                      <td v-text="user.name"></td>
                      <td v-text="user.job"></td>
                      <td>
                        <button class="btn btn-info"
                          @click="loadUserFunctions(user)"
                          data-toggle="modal"
                          data-target="#UserFunctionsManager">
                          <i class="fa fa-tasks"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
            <div class="card-footer">
            <pagination :data="Users" @pagination-change-page="getUsuarios"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="UserFunctionsManager" tabindex="1" role="dialog" aria-labelledby="UserFunctionsManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title">
              Funciones del usuario {{ currentUser.name }}
              <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva función">
                <button class="btn btn-primary"
                data-toggle="modal"
                data-target="#UserFunctionEditor">
                  <i class="fa fa-plus-circle"></i>
                </button>
              </div>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead class="">
                      <tr>
                        <th> Función </th>
                        <th> Acciones </th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="userFunction in UserFunctions" :key="userFunction.id">
                          <td v-text="userFunction.user_functions"></td>
                          <td>
                            <button class="btn btn-info"
                              @click="loadUserFunctionsEditor(userFunction)"
                              data-toggle="modal"
                              data-target="#UserFunctionEditor">
                              <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger"
                              data-toggle="tooltip"
                              data-placement="top"
                              title="Eliminar funciones asignadas" @click="deleteUserFunction(userFunction)">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer">
                <div class="container-buttons">
                  <button @click="exitUserFunctionManager()" class="btn btn-secondary">Salir</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="UserFunctionEditor" tabindex="2" role="dialog" aria-labelledby="UserFunctionEditor-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="UserFunctionEditorModalLabel"> {{ title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Descripción</label>
                          <input v-model="form.user_functions" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('user_functions') }">
                          <has-error :form="form" field="user_functions"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="update== 0" @click="saveUserFunction()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateUserFunction()" class="btn btn-info">Actualizar</button>
                        <button @click="exit()" class="btn btn-secondary">Atrás</button>
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
  </div>
</template>

<script>
export default {
  data(){
    return{
      form: new Form ({
        id:"",//User ID
        user_id:"",
        user_functions:""
      }),
      currentUser:{},
      title:"Agregar funciones del usuario", //title to show
      update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
      Users:{}, //BD content
      UserFunctions:{},
      Projects:{},
      currentProject:''
      }
  },
  methods:{
    getUsuarios(page = 1) {
      let me =this;
      axios.get('/usuarios-por-proyecto/'+me.currentProject+'?page=' + page)
      .then(response => {
            me.Users = response.data; //get all projects from page
      });
    },
    getProjectos(){
      let me =this;
      me.clearFields();
      axios.get('/todos-los-proyectos')
      .then(response => {
            me.Projects = response.data; //get all projects from page
      });
    },
    loadUserFunctionsEditor(userFunction){
      let me = this
      me.form.fill(userFunction)
      me.update=1
      me.title="Modificar funciones del usuario"
    },
    saveUserFunction(){
      let me =this;
      me.form.user_id= me.currentUser.id
      me.form.post('/funciones/guardar')
      .then(function (response) {
          $('#UserFunctionEditor').modal('toggle')
          me.loadUserFunctions(me.currentUser)
          me.exit()
          toast.fire({
            type: 'success',
            title: 'Función de usuario registrada con éxito'
          });

      })
      .catch(function (error) {
          console.log(error);
      });

    },
    showUserFunction(userFunction){
      let me = this
      me.title="Modificar funciones del usuario"
      me.update = 1
      me.form.fill(userFunction)
    },
    updateUserFunction(){
      let me = this;
      me.form.put('/funciones/actualizar')
      .then(function (response) {
        me.loadUserFunctions(me.currentUser)
        me.exit()
       toast.fire({
          type: 'success',
          title: 'Función de usuario actualizada con éxito'
         });
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    loadUserFunctions(user){
      let me =this;
      me.currentUser = user
      axios.get('/funciones/'+ user.id)
      .then(response => {
          me.UserFunctions = response.data; //get all projects from page
      })
      .catch(function (error) {
          console.log(error)
      });
    },
    deleteUserFunction(userFunction){
      let me =this;
      swal.fire({
        title: 'Eliminar funciones de usuario',
        text: "Esta acción no se puede revertir, Está a punto de eliminar las funciones de un usuario",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/funciones/borrar/'+userFunction.id)
          .then(function (response) {
            me.loadUserFunctions(me.currentUser)
            swal.fire(
              'Eliminado',
              'Usuario fue eliminado',
              'success'
            )
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    exitUserFunctionManager(){
      $('#UserFunctionsManager').modal('toggle');
    },
    exit(){
      $('#UserFunctionEditor').modal('toggle');
      this.clearFields();
    },
    clearFields(){
      let me =this;
      me.title= "Agregar funciones del usuario";
      me.update = 0;
      me.form.reset();
    }
  },
  created(){
    Fire.$on('searching',() => {
        let query = this.$parent.search;
        axios.get('/finduser?q=' + query)
        .then((response) => {
            this.Users = response.data
        })
        .catch(() => {
        })
    })
  },
  mounted() {
    this.getProjectos()
  }
}
</script>
