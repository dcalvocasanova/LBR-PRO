<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-8">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de proyectos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre </th>
                      <th style="width: 72px;"> Logo </th>
                      <th> Niveles </th>
                      <th> Acciones </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="project in Projects.data" :key="project.id" >
                        <td v-text="project.name"></td>
                        <td> <img class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                        <td>
                            <button class="btn btn-primary" @click="loadLevelData(project)" data-toggle="modal" data-target="#addLevels"><i class="fas fa-swatchbook"> Niveles de estructura</i></button>
                        </td>
                        <td>
                            <button class="btn btn-info" @click="loadFieldsUpdate(project)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger" @click="deleteProject(project)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Projects" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
          	  <h6 class="m-0 font-weight-bold text-primary">{{ title }}</h6>
          	</div>
            <div class="card-body">
              <div class="form-group">
                  <label>Nombre</label>
                  <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                  <label>Descripción</label>
                  <input v-model="form.description" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="logo_project" class="col-sm-8 control-label file-uploader">  <i class="fas fa-cloud-upload-alt"> Logo del proyecto <span v-html="loadLogoProject"></span></i> </label>
                <div class="col-sm-12">
                    <input type="file" @change="updateLogo" name="logo_project" id="logo_project" class="form-input" style='display: none;'>
                </div>
              </div>
              <div class="form-group">
                <label class="typo__label">Detalles adicionales</label>
                <multiselect
                  v-model="value"
                  placeholder="Buscar opciones" label="name"
                  track-by="code"
                  :options="options"
                  :multiple="true"
                  :taggable="false"
                  :show-labels="false">
                </multiselect>
              </div>
              <div class="container-buttons">
                <button v-if="update == 0" @click="saveProjects()" class="btn btn-success">Añadir</button>
                <button v-if="update != 0" @click="updateProjects()" class="btn btn-info">Actualizar</button>
                <button v-if="update != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
            </div>
          </div>
        </div>
      </div>
      </div>

      <div class="modal fade" id="addLevels" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="exampleModalLabel">Niveles de estructura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-plain">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title mt-0"> Lista de niveles</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="">
                          <tr>
                            <th> Nombre </th>
                            <th> Detalle </th>
                            <th> Acciones </th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr  v-for="level in Levels.data" :key="level.id">
                              <td v-text="level.name"></td>
                              <td v-text="level.description"></td>
                              <td>
                                <button class="btn btn-info" @click="loadLevelUpdate(level)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" @click="deleteLevel(level)"><i class="fas fa-trash-alt"></i></button>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer">
                    <pagination :data="Levels" @pagination-change-page="getResultLevel"></pagination>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ title_level }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="level.nombre" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                          <has-error :form="level" field="nombre"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nivel</label>
                          <input type="text" v-model="level.nivel"  class="form-control":class="{ 'is-invalid': form.errors.has('nivel') }">
                          <has-error :form="level" field="nivel"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Descripción</label>
                          <input v-model="level.descripcion" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('descripcion') }">
                          <has-error :form="level" field="descripcion"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="updateLevelId == 0" @click="saveLevel()" class="btn btn-success">Añadir</button>
                        <button v-if="updateLevelId != 0" @click="updateLevel()" class="btn btn-info">Actualizar</button>
                        <button v-if="updateLevelId != 0" @click="clearFieldsLevel()" class="btn btn-secondary">Atrás</button>
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
  import Multiselect from 'vue-multiselect'
    export default {
        components: {
          Multiselect
        },
        data(){
            return{
                form: new Form ({
                  id:"",//Project ID
                  name:"", //Project name
                  logo_project:"", //Project's logo
                  logo_sponsor:"", //Sponsor's logo
                  logo_auxiliar:"", //Auxiliar's logo
                  description:"", // description
                }),
                level: new Form({
                  id:"", //level projectID
                  nombre:"",
                  nivel:"",
                  descripcion:"",
                  proyecto:""
                }),
                project_id:0,
                title:"Agregar nuevo proyecto", //title to show
                title_level:"Agregar nuevo nivel",
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                updateLevelId:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                loadLogoProject:"",
                Projects:{}, //All registered projects
                Levels:{}, // All level from organization
                value: [
                  { name: 'Gratuito', code: 'LI' }
                ],
                options: [
                  { name: 'Premium', code: 'PU' },
                  { name: 'Estudiante', code: 'ES' },
                  { name: 'Gratito', code: 'LI' },
                  { name: 'Usa macroprocesos', code: 'MA' },
                  { name: 'Usa funciones', code: 'FU' }
                ]
            }
        },
        methods:{
            getResults(page = 1) {
              axios.get('/proyectos?page=' + page)
              .then(response => {
                    this.Projects = response.data; //get all projects from page
              });
            },
            getLogo(project){
                let logo = (project.logo_project.length > 200) ? project.logo_project : "img/profile-prj/"+ project.logo_project ;
                return logo;
            },
            updateLogo(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                if (this.validateFile(file)){
                  this.loadLogoProject ='<i class="far fa-check-circle"> <h6> agregado</h6> </i> ';
                  reader.onloadend = (file) => {
                      this.form.logo_project = reader.result;
                  }
                  reader.readAsDataURL(file);
                }
            },
            validateFile(file){
              let limit = 1024*1024*2;
              if(file['size'] > limit){
                  return false;
              }
              return true;

            },
            getProjects(){
                let me =this;
                me.clearFields();
                axios.get('/proyectos').then(function (response) {
                    me.Projects = response.data; //get all projects
                    me.title= "Agregar nuevo proyecto";
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveProjects(){
                let me =this;
                this.form.post('/proyectos/guardar')
                .then(function (response) {
                    me.form.reset();
                    me.getProjects();// show all projetcs

                    toast.fire({
                      type: 'success',
                      title: 'Proyecto agregado con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateProjects(){
                let me = this;
                this.form.put('/proyectos/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Proyecto actualizado con éxito'
                   });
                   me.getProjects();
                   me.form.reset();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(project){
                this.update = project.id
                let me =this;
                me.title="Actualizar proyecto";
                let url = '/proyectos/buscar?id='+this.update;
                axios.get(url).then(function (response) {
                  me.form.fill(response.data);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            deleteProject(project){
              let me =this;
              let project_id = project.id
              swal.fire({
                title: 'Eliminar un proyecto',
                text: "Esta acción no se puede revertir, Está a punto de eliminar un proyecto",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarlo!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/proyectos/borrar/'+project_id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Proyecto fue eliminado',
                      'success'
                    )
                    me.getProjects();
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
                }
              })
            },
            getResultLevel(page = 1){
              axios.get('/estructura?page=' + page)
              .then(response => {
                    this.Levels = response.data; //get all projects from page
              });
            },
            loadLevelUpdate(level){
              this.updateLevelId = level.id;
              let me =this;
              me.title="Actualizar nivel";
              let url = '/estructura/buscar?id='+this.updateLevelId;
              axios.get(url).then(function (response) {
                me.level.nombre = response.data.name;
                me.level.id = response.data.id;
                me.level.descripcion = response.data.description;
                me.level.nivel = response.data.level;
              })
              .catch(function (error) {
                  // handle error
                  console.log(error);
              });
            },
            deleteLevel(level){
              let me =this;
              let level_id = level.id
              swal.fire({
                title: 'Eliminar un nivel',
                text: "Esta acción no se puede revertir, Está a punto de eliminar un nivel",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarlo!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/estructura/borrar/'+level_id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Nivel fue eliminado',
                      'success'
                    )
                    me.getLevels();
                    me.clearFieldsLevel();
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
                }
              })
            },
            getLevels(){
                let me =this;
                me.clearFieldsLevel();
                let url = '/estructura?id='+me.project_id;
                axios.get(url).then(function (response) {
                    me.Levels = response.data; //get all projects

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveLevel(){
                let me =this;
                me.level.proyecto =me.project_id;
                this.level.post('/estructura/guardar')
                .then(function (response) {
                    me.level.reset();
                    me.getLevels();// show all levels
                    me.clearFieldsLevel();
                    toast.fire({
                      type: 'success',
                      title: 'Nivel agregado con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateLevel(){
                let me = this;
                this.level.put('/estructura/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Proyecto actualizado con éxito'
                   });
                   me.getLevels();
                   me.clearFieldsLevel();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            clearFields(){
                let me =this;
                me.loadLogoProject ='';
                me.title= "Agregar nuevo proyecto";
                me.update = 0;
                me.form.reset();
                me.value= [];
            },
            clearFieldsLevel(){
                let me =this;
                me.title_level= "Agregar nuevo nivel";
                me.updateLevelId = 0;
                me.level.reset();
            },
            loadLevelData(project){
              this.clearFieldsLevel();
              this.project_id = project.id;
              this.getLevels();
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
