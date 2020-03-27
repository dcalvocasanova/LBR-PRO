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
                    <th> Agregar funciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr  v-for="user in Users.data" :key="user.id">
                      <td v-text="user.name"></td>
                      <td v-text="user.job"></td>
                      <td>
                        <button class="btn btn-info" @click="loadFieldsUpdate(user)"><i class="fa fa-tasks"></i></button>
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
      title:"Agregar nuevo usuario", //title to show
      update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
      Users:{}, //BD content
      Projects:{},
      currentProject:''
      }
  },
  methods:{
    getUsuarios(page = 1) {
      let me =this;
      me.clearFields();
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

    saveUser(){
      let me =this;
      this.form.post('/usuarios/guardar')
      .then(function (response) {
          me.clearFields();
          me.getUsuarios();// show all users
          toast.fire({
            type: 'success',
            title: 'Usuario registrado con éxito'
          });
      })
      .catch(function (error) {
          console.log(error);
      });

    },
    updateUser(){
        let me = this;
        me.form.role="Usuario";
        me.form.put('/usuarios/actualizar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Usuario actualizado con éxito'
           });
           me.getUsuarios();
           me.clearFields();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    loadFieldsUpdate(user){
      let me =this;
      this.form.fill(user);
      me.update = user.id
      me.title="Actualizar información del usuario";
    },
    deleteUser(user){
      let me =this;
      let user_id = user.id
      swal.fire({
        title: 'Eliminar un usuario',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un usuario",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/usuarios/borrar/'+user_id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'Usuario fue eliminado',
              'success'
            )
            me.getUsuarios();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
      let me =this;
      me.title= "Registrar nuevo usuario";
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
