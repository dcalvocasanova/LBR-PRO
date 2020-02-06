<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-5">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de usuarios</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre </th>
                      <th style="width: 92px;"> Foto </th>
                      <th> tipo </th>
                      <th> Acciones </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="user in Users.data" :key="user.id">
                        <td v-text="user.name"></td>
                        <td> <img class="img-profile-pic rounded-circle" :src="getAvatar(user)" alt="User avatar"/> </td>
                        <td v-text="user.type"></td>
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
              <pagination :data="Users" @pagination-change-page="getResults"></pagination>
            </div>
          </div>

          <div class="col-6" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo parámetro">
            <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#loadUsers">
              Cargar usuario usando un archivo
              <i class="fa fa-plus-circle"></i>
            </button>
          </div>
        </div>
        <div class="col-md-7">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ title }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-7">
                  <div class="form-group">
                    <label class="bmd-label-floating">Identificación</label>
                    <input v-model="form.identificacion" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('identificacion') }">
                    <has-error :form="form" field="identificacion"></has-error>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input v-model="form.nombre" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Fecha nacimiento</label>
                    <input type="date" v-model="form.fecha_nacimiento"  class="form-control":class="{ 'is-invalid': form.errors.has('fecha_nacimiento') }">
                    <has-error :form="form" field="fecha_nacimiento"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Email</label>
                    <input type="email" v-model="form.email"  class="form-control":class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Tipo</label>
                    <select v-model="form.tipo" class=" form-control" :class="{ 'is-invalid': form.errors.has('tipo')}">
                      <option>Administrador</option>
                      <option>Usuario</option>
                    </select>
                    <has-error :form="form" field="error"></has-error>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Salario</label>
                    <input type="number" v-model="form.salario"  class="form-control":class="{ 'is-invalid': form.errors.has('salario') }">
                    <has-error :form="form" field="salario"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Puesto de trabajo</label>
                    <input type="text" v-model="form.puesto"  class="form-control":class="{ 'is-invalid': form.errors.has('puesto') }">
                    <has-error :form="form" field="puesto"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Cargo</label>
                    <input type="text" v-model="form.cargo"  class="form-control":class="{ 'is-invalid': form.errors.has('cargo') }">
                    <has-error :form="form" field="cargo"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Educación formal</label>
                    <input type="text" v-model="form.educacion"  class="form-control":class="{ 'is-invalid': form.errors.has('educacion') }">
                    <has-error :form="form" field="cargo"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Jornada</label>
                    <input type="text" v-model="form.jornada"  class="form-control":class="{ 'is-invalid': form.errors.has('jornada') }">
                    <has-error :form="form" field="jornada"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Fecha ingreso al puesto</label>
                    <input type="date" v-model="form.fecha_ingreso"  class="form-control":class="{ 'is-invalid': form.errors.has('fecha_ingreso') }">
                    <has-error :form="form" field="fecha_ingreso"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Género</label>
                    <select v-model="form.genero" class=" form-control":class="{ 'is-invalid': form.errors.has('genero') }">
                      <option>Hombre</option>
                      <option>Mujer</option>
                      <option>Otros</option>
                    </select>
                    <has-error :form="form" field="genero"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Sexo</label>
                    <select v-model="form.sexo" class=" form-control":class=" { 'is-invalid': form.errors.has('sexo') }">
                      <option>Masculino</option>
                      <option>Femenino</option>
                    </select>
                    <has-error :form="form" field="sexo"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Étnia</label>
                    <select v-model="form.etnia" class=" form-control":class=" { 'is-invalid': form.errors.has('etnia') }">
                      <option>Aborigen</option>
                      <option>Afrocostarricense</option>
                      <option>Mestizo</option>
                      <option>Mulato</option>
                      <option>Otros</option>
                    </select>
                    <has-error :form="form" field="etnia"></has-error>
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
      <div class="modal fade" id="loadUsers" tabindex="-1" role="dialog" aria-labelledby="loadUsersModalLabel-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="ParameterModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title">Cargar usuarios usando un archivo excel</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="bmd-label-floating">Cargar archivo</label>
                            <input  type="file" id ="procesar_archivo" @change="EventSubir">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <button  @click="getResults()" data-dismiss="modal" class="btn btn-success">Regresar</button>
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
                  nombre:"",
                  email:"",
                  genero:"",
                  sexo:"",
                  etnia:"",
                  fecha_nacimiento:"",
                  fecha_ingreso:"",
                  puesto:"",
                  cargo:"",
                  salario:"",
                  jornada:"",
                  educacion:"",
                  avatar:""
                }),
                title:"Agregar nuevo usuario", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                loadLogoProject:"",
<<<<<<< HEAD
=======
				        userFile:"",
>>>>>>> 21f265312efc7011f80b19552223acf85d48dbf2
                Users:{}, //BD content
            }
        },
        methods:{
<<<<<<< HEAD
=======
			loadfile(event){
				var files = event.target.files || event.dataTransfer.files;
				this.userFile = event.target.files[0];
				alert(files[0]);
				axios.post('/usuarios/loadusers',{users:this.userFile})
					.then(function(response){console.log(response)})
					.catch(function(response){console.log(response)})
				;
			},

			EventSubir(f){
            let me =this;
            me.userFile = f.target.files[0];
            console.log(me.userFile);
            var data = new FormData();
            data.append('archivo', me.userFile);
            axios.post('/usuarios/loadusers', data, {
                headers: {
                  'Content-Type': 'multipart/form-data'
                }
              }
            )
            .then(response => {
              toast.fire({
                type: 'success',
                title: 'Se cargó el archivo'
              });
            })
            .catch(function (error) {
                console.log(error);
                alert("no funca");
            });
        },


        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        },

>>>>>>> 21f265312efc7011f80b19552223acf85d48dbf2
            getResults(page = 1) {
              axios.get('/usuarios?page=' + page)
              .then(response => {
                    this.Users = response.data; //get all projects from page
              });
            },
            getAvatar(user){
                let logo = (user.avatar.length > 200) ? user.avatar : "img/profile-usr/"+ user.avatar;
                return logo;
            },
<<<<<<< HEAD
=======

>>>>>>> 21f265312efc7011f80b19552223acf85d48dbf2
            getUsuarios(){
                let me =this;
                me.clearFields();
                axios.get('/usuarios').then(function (response) {
                    me.Users = response.data; //get all projects
                    me.title= "Registrar nuevo usuario";
                })
                .catch(function (error) {
                    console.log(error);
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
                me.title="Actualizar información del usuario";
                let url = '/usuarios/buscar?id='+this.update;
                axios.get(url).then(function (response) {
                  me.form.nombre = response.data.name;
                  me.form.email = response.data.email;
                  me.form.genero = response.data.gender;
                  me.form.sexo = response.data.sex;
                  me.form.etnia = response.data.ethnic;
                  me.form.tipo = response.data.type;
                  me.form.identificacion = response.data.identification;
                  me.form.id = response.data.id;
                  me.form.fecha_nacimiento=response.data.birthday;
                  me.form.fecha_ingreso=response.data.workingsince;
                  me.form.puesto=response.data.job;
                  me.form.cargo=response.data.position;
                  me.form.educacion=response.data.education;
                  me.form.jornada=response.data.workday;
                  me.form.salario=response.data.salary;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
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
           this.getUsuarios();
        }
    }
</script>
