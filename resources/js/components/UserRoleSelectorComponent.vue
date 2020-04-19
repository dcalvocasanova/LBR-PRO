<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddUsers === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se gestionaran los roles de los usuarios</h4>
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
    <div class="row" v-if="this.selectingProjectToAddUsers === false">
        <div class="col-md-8">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de usuarios</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Seleccionar </th>
                      <th> Nombre </th>
                      <th> Puesto </th>
                      <th> Role </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="user in Users.data" :key="user.id">
                        <td>
                          <input v-model="form.users" type="checkbox"
                          :name="user.id"
                          :value="user.id">
                        </td>
                        <td v-text="user.name"></td>
                        <td v-text="user.position"></td>
                        <td v-if="user.roles.length" v-text="user.roles[0].name"></td>
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
        <div class="col-md-4">
          <h2>Seleccionar rol a asignar </h2>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label class="bmd-label-floating">Rol de usuario</label>
                <br>
                <select v-model="form.role" class="form-control">
                  <option v-for="r in Roles.data" :value="r">{{ r }}</option>
                  <option value="remove"> Quitar Rol </option>
                </select>
              </div>
            </div>
          </div>

          <div class="container-buttons">
            <button @click="saveRoleToUser()" class="btn btn-success">Asignar rol</button>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
     showDeleteAndUpdateButton: Number,
  },
  data(){
    return{
      form: new Form ({
        users:[],
        role:""
      }),
      selectingProjectToAddUsers:true,
      currentProject:0,
      Users:{}, //BD content
      Projects:{},
      Roles:{}
    }
  },
  methods:{
    setProject(){
      let me = this
      me.selectingProjectToAddUsers=false
      me.getUsuarios()
      me.loadRoles()
    },
    getUsuarios(page = 1) {
      let me =this;
      axios.get('/usuarios-por-proyecto/'+me.currentProject+'?page=' + page)
      .then(response => {
            me.Users = response.data; //get all projects from page
      });
    },
    getProjectos(){
      let me =this;
      axios.get('/todos-los-proyectos')
      .then(response => {
            me.Projects = response.data; //get all projects from page
      });
    },
    loadRoles() {
      let me = this
      axios.get('/catalogo/roles-usuario')
      .then(response => {
          me.Roles = response; //get all user's roles
      });
    },
    saveRoleToUser(){
      let me = this;
      if(me.form.role.trim()!="" && me.form.users.length >0){
        me.form.put('/usuarios/asignar-roles')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Roles de usuarios actualizados con éxito'
           });
           me.form.users=[]
           me.getUsuarios()
        })
        .catch(function (error) {
            console.log(error);
        });
      }else{
        swal.fire(
          'Datos incompletos',
          'Es necesario seleccionar los usuarios y el rol que se desea asignar',
          'warning'
        )
      }
    },
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
