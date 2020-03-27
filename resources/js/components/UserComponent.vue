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
                      <th style="width: 192px;"> Foto </th>
                      <th> email </th>
                      <th v-show="showDeleteAndUpdateButton"> Acciones </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="user in Users.data" :key="user.id">
                        <td v-text="user.name"></td>
                        <td> <img class="img-profile-pic rounded-circle" :src="getAvatar(user)" alt="User avatar"/> </td>
                        <td v-text="user.email"></td>
                        <td v-show="showDeleteAndUpdateButton">
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
        <!--
          <div class="col-6" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo parámetro">
            <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#loadUsers">
              Cargar usuario usando un archivo
              <i class="fa fa-plus-circle"></i>
            </button>
          </div>
        -->
        </div>
        <div class="col-md-7">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ title }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Asociado al proyecto</label>
                    <select v-model="form.relatedProjects" class="form-control":class="{ 'is-invalid': form.errors.has('relatedProjects') }">
                      <option v-for="p in Projects" :value="p.id">{{ p.name }}</option>
                    </select>
                    <has-error :form="form" field="relatedProjects"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7">
                  <div class="form-group">
                    <label class="bmd-label-floating">Identificación</label>
                    <input v-model="form.identification" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('identification') }">
                    <has-error :form="form" field="identification"></has-error>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Fecha nacimiento</label>
                    <input type="date" v-model="form.birthday"
                      class="form-control":class="{ 'is-invalid': form.errors.has('birthday') }">
                    <has-error :form="form" field="birthday"></has-error>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="bmd-label-floating">Email</label>
                    <input type="email" v-model="form.email"  class="form-control":class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Salario</label>
                    <input type="number" v-model="form.salary"  class="form-control":class="{ 'is-invalid': form.errors.has('salary') }">
                    <has-error :form="form" field="salary"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Puesto de trabajo</label>
                    <input type="text" v-model="form.job"  class="form-control":class="{ 'is-invalid': form.errors.has('job') }">
                    <has-error :form="form" field="job"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Cargo</label>
                    <input type="text" v-model="form.position"  class="form-control":class="{ 'is-invalid': form.errors.has('position') }">
                    <has-error :form="form" field="position"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Educación formal</label>
                    <input type="text" v-model="form.education"  class="form-control":class="{ 'is-invalid': form.errors.has('education') }">
                    <has-error :form="form" field="position"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Jornada</label>
                    <input type="text" v-model="form.workday"  class="form-control":class="{ 'is-invalid': form.errors.has('workday') }">
                    <has-error :form="form" field="workday"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Fecha ingreso al job</label>
                    <input type="date" v-model="form.workingsince"  class="form-control":class="{ 'is-invalid': form.errors.has('workingsince') }">
                    <has-error :form="form" field="workingsince"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Género</label>
                    <select v-model="form.gender" class=" form-control":class="{ 'is-invalid': form.errors.has('gender') }">
                      <option v-for="gender in Genders">{{ gender.name }}</option>
                    </select>
                    <has-error :form="form" field="gender"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Sexo</label>
                    <select v-model="form.sex" class=" form-control":class=" { 'is-invalid': form.errors.has('sex') }">
                      <option v-for="s in Sex">{{ s.name }}</option>
                    </select>
                    <has-error :form="form" field="sex"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Étnia</label>
                    <select v-model="form.ethnic" class=" form-control":class=" { 'is-invalid': form.errors.has('ethnic') }">
                      <option v-for="ethnic in Ethnics">{{ ethnic.name }}</option>
                    </select>
                    <has-error :form="form" field="ethnic"></has-error>
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
                <button @click="getTemplate" class="btn btn-success">Generar archivo</button>
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
                          <button @click="getUsuarios" data-dismiss="modal" class="btn btn-success">Regresar</button>
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
  props: {
     showDeleteAndUpdateButton: Number,
  },
  data(){
    return{
          form: new Form ({
            id:"",//User ID
            identification:"",
            name:"",
            email:"",
            gender:"",
            sex:"",
            ethnic:"",
            type:"web",
            birthday:"",
            workingsince:"",
            job:"",
            position:"",
            salary:"",
            workday:"",
            education:"",
            avatar:"",
            relatedProjects:""
          }),
          title:"Agregar nuevo usuario", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
	        userFile:"",
          Users:{}, //BD content
          Projects:{},
          Sex:{},
          Genders:{},
          Ethnics:{}
      }
  },
  methods:{
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
    getUsuarios(page = 1) {
      let me =this;
      me.clearFields();
      axios.get('/usuarios?page=' + page)
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
    getTemplate() {
      let me =this;
      axios.get('/usuarios-plantilla')
      .then(response => {
        let blob = new Blob([response.data],{ type:'application/vnd.ms-excel'});
        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = "users";
        link.click();
      });
    },
    getAvatar(user){
        let logo = (user.avatar.length > 200) ? user.avatar : "img/profile-usr/"+ user.avatar;
        return logo;
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
    },
    LoadCatalogSex() {
      axios.get('catalogo?id=SEX')
      .then(response => {
            this.Sex = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogGender() {
      axios.get('catalogo?id=GENDER')
      .then(response => {
            this.Genders = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogEthnic() {
      axios.get('catalogo?id=ETHNIC')
      .then(response => {
            this.Ethnics = response.data; //get all catalogs from category selected
      });
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
     this.getUsuarios()
     this.LoadCatalogSex()
     this.LoadCatalogGender()
     this.LoadCatalogEthnic()
  }
}
</script>
