<template>
    <div class="container container-project">
        <div class="row">
            <div class="col-md-6">
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
                            <tr v-for="project in arrayProjects" :key="project.id" role="row" class="odd">
                                <td v-text="project.name"></td>
                                <td> <img class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                                <td v-text="project.description"></td>
                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la proyecto seleccionada-->
                                    <button class="btn btn-info" @click="loadFieldsUpdate(project)">Modificar</button>
                                    <!--Botón que borra la proyecto que seleccionemos-->
                                    <button class="btn btn-danger" @click="deleteProject(project)">Borrar</button>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite"> Entradas: x </div>
                      </div>
                      <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                          <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="dataTable_previous">
                              <a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                            </li>
                            <li class="paginate_button page-item active">
                              <a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                            </li>
                            <li class="paginate_button page-item next" id="dataTable_next">
                              <a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
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
                  <label for="photo" class="col-sm-6 control-label">Logo del proyecto</label>
                  <div class="col-sm-12">
                      <input type="file" @change="updateLogo" name="logo_project" class="form-input">
                  </div>
                </div>

                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveProjects()" class="btn btn-success">Añadir</button>
                    <!-- Botón que modifica la proyecto que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateProjects()" class="btn btn-info">Actualizar</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
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
                  id:"",//Project ID
                  name:"", //Project name
                  logo_project:"", //Project's logo
                  logo_sponsor:"", //Sponsor's logo
                  logo_auxiliar:"", //Auxiliar's logo
                  description:"", // description
                }),
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                arrayProjects:[], //BD content
            }
        },
        methods:{
            getLogo(project){
                let logo = (project.logo_project.length > 200) ? project.logo_project : "img/profile-prj/"+ project.logo_project ;
                return logo;
            },
            updateLogo(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                if (this.validateFile(file)){
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
                axios.get('/proyectos').then(function (response) {
                    me.arrayProjects = response.data; //get all projects
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveProjects(){
                let me =this;
                this.form.post('/proyectos/guardar')
                .then(function (response) {
                    this.form.reset();
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
                if (confirm('¿Seguro que deseas borrar este Proyecto?')) {
                    axios.delete('/proyectos/borrar/'+project_id
                    ).then(function (response) {
                        me.getProjects();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            clearFields(){
                this.form.reset();
            }
        },
        mounted() {
           this.getProjects();
        }
    }
</script>
