<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-8">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Lista de proyectos</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                    <div class="col-sm-12">
                      <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                          <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending"  style="width: 57px;">Nombre</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 62px;">Logo</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 50px;">Detalles</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 31px;">Acciones</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th rowspan="1" colspan="1">Nombre</th>
                            <th rowspan="1" colspan="1">Logo</th>
                            <th rowspan="1" colspan="1">Detalles</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <tr v-for="project in Projects.data" :key="project.id" role="row" class="odd">
                              <td v-text="project.name"></td>
                              <td> <img class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                              <td v-text="project.description"></td>
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
<!--
              <div class="form-group">
                <label for="macroprocesos" class="btn btn-primary">Utiliza macroprocesos <input type="checkbox" id="macroprocesos" class="badgebox"><span class="badge">&check;</span></label>
              </div>
              <div class="form-group">
                <label for="funciones" class="btn btn-primary">Utiliza funciones <input type="checkbox" id="funciones" class="badgebox"><span class="badge">&check;</span></label>
              </div>

              <div class="form-group">
                <label for="funciones" class="btn btn-primary">Utiliza funciones <input type="checkbox" id="funciones" class="badgebox"><span class="badge">&check;</span></label>
              </div>
            -->
              <div class="form-group">
                <label class="typo__label">Detalles</label>
                <multiselect v-model="value" tag-placeholder="Agregar Opción" placeholder="Buscar opciones" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>

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
                title:"Agregar nuevo proyecto", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                loadLogoProject:"",
                Projects:{}, //BD content
                value: [
                  { name: 'Gratuito', code: 'LI' }
                ],
                options: [
                  { name: 'Premium', code: 'PU' },
                  { name: 'Estudiante', code: 'ES' },
                  { name: 'Gratito', code: 'LI' },
                  { name: 'Usa macroprocesos', code: 'MA' },
                  { name: 'Usa funciones', code: 'FU' },
                  { name: 'Nueva Propiedad', code: 'NU' }
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
            addTag (newTag) {
              const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
              }
              this.options.push(tag)
              this.value.push(tag)
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
            loadFieldsUpdate(data){
                this.update = data.id
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
            deleteProject(data){
              let me =this;
              let project_id = data.id
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
            clearFields(){
                let me =this;
                me.loadLogoProject ='';
                me.title= "Agregar nuevo proyecto";
                me.update = 0;
                me.form.reset();
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
