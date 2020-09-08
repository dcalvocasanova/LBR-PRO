<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-7 col-sm-12">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de usuarios del sistema</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre </th>
                      <th style="width: 192px;"> Foto </th>
                      <th> Rol </th>
                      <th> Acciones </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="user in Users.data" :key="user.id">
                        <td v-text="user.name"></td>
                        <td> <img class="img-profile-pic rounded-circle" :src="getAvatar(user)" alt="User avatar"/> </td>
                        <td v-if="user.roles.length > 0"> {{user.roles[0].name}}</td>
                        <td>
                          <button class="btn btn-info" @click="loadFieldsUpdate(user)"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger" @click="deleteUser(user)"><i class="fas fa-trash-alt"></i></button>
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
        <div class="col-md-5 col-sm-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ title }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Identificación</label>
                    <input v-model="form.identification" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('identification') }">
                    <has-error :form="form" field="identification"></has-error>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Email</label>
                    <input type="email" v-model="form.email"  class="form-control":class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Rol</label>
                    <select v-model="form.role" class=" form-control" :class="{ 'is-invalid': form.errors.has('role')}">
                      <option v-for="role in Roles.data">{{ role.name }}</option>
                    </select>
                    <has-error :form="form" field="error"></has-error>
                  </div>
                </div>
              </div>
              <div class="container-buttons">
                <button v-if="update == 0" @click="saveUser()" class="btn btn-success">Añadir</button>
                <button v-if="update != 0" @click="updateUser()" class="btn btn-info">Actualizar</button>
                <button v-if="update != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
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
          name:"",
          identification:"",
          email:"",
          type:"sys",
          role:"",
          relatedProjects:"-",
          relatedLevel:"-"
        }),
        title:"Agregar nuevo usuario", //title to show
        update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
        type:"sys",
        test:"",
        Users:{},
        Roles:{}
      }
    },
    methods:{
      getUsuarios(page = 1) {
        let me =this;
        me.title= "Registrar nuevo usuario";
        axios.get('/usuarios/del-sistema?page='+ page)
        .then(response => {
            this.Users = response.data; //get all projects from page
        });
      },
      getAvatar(user){
        let logo = (user.avatar.length > 200) ? user.avatar : "img/profile-usr/"+ user.avatar;
        return logo;
      },
      saveUser(){
        let me =this;
        me.form.relatedProjects= -1
        if(me.form.role !== ''){
          me.form.post('/usuarios/guardar')
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
        }else{
          swal.fire(
            'Datos incompletos',
            'Es necesario seleccionar el rol que se desea asignar',
            'warning'
          )
        }

      },
      updateUser(){
        let me = this;
        this.form.put('/usuarios/actualizar')
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
        this.update = user.id
        let me =this;
        me.form.fill(user);
        if(user.roles.length > 0){
            me.form.role=user.roles[0].name;
        }
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
        me.loadLogoProject ='';
        me.title= "Registrar nuevo usuario";
        me.update = 0;
        me.form.reset();
      },
      loadRoles() {
        let me = this
        axios.get('/catalogo/roles')
        .then(response => {
            me.Roles = response; //get all user's roles
        });
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
          }),
          this.loadRoles();
      },
    mounted() {
         this.getUsuarios();
      }
  }
</script>
