<template>
  <div class="container container-project">
    <div class="row">
        <div class="col-md-7">
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
                      <th style="width: 172px;"> Logo </th>
                      <th v-show="showDeleteAndUpdateButton"> Acciones </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="project in Projects.data" :key="project.id" >
                        <td v-text="project.name"></td>
                        <td> <img class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                        <td v-show="showDeleteAndUpdateButton">
                            <button class="btn btn-info" @click="loadFieldsUpdate(project)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger" @click="deleteProject(project)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Projects" @pagination-change-page="getProjectsPaginator"></pagination>
            </div>
          </div>
        </div>
        <div class="col-md-5">
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
                  <label>Ubicación geográfica</label>
                  <br>
                  <label> Latitud</label>
                  <input v-model="form.latitud" type="text" class="form-control">
                  <label> Longitud</label>
                  <input v-model="form.longitud" type="text" class="form-control">
              </div>
              <div class="form-group">
                  <label>Actividad económica</label>
                  <select v-model="form.actividad_economica" class=" form-control">
                    <option v-for="activity in Economics">{{ activity.name }}</option>
                  </select>

              </div>
              <div class="form-group">
                <label for="logo_organization" class="col-sm-8 control-label file-uploader">  <i class="fas fa-cloud-upload-alt"> Logo de la organización <span v-html="loadLogoProject"></span></i> </label>
                <div class="col-sm-12">
                    <input type="file" @change="loadLogoOrganization" name="logo_organization" id="logo_organization" class="form-input" style='display: none;'>
                </div>
              </div>

              <div class="form-group">
                <label for="logo_institution" class="col-sm-8 control-label file-uploader">  <i class="fas fa-cloud-upload-alt"> Logo de la institución <span v-html="loadLogoSponsor"></span></i> </label>
                <div class="col-sm-12">
                    <input type="file" @change="loadLogoInstitution" name="logo_institution" id="logo_institution" class="form-input" style='display: none;'>
                </div>
              </div>

              <div class="form-group">
                <label for="logo_project" class="col-sm-10 control-label file-uploader">  <i class="fas fa-cloud-upload-alt"> Logo del proyecto <span v-html="loadLogoAuxiliar"></span></i> </label>
                <div class="col-sm-12">
                    <input type="file" @change="loadLogoAuxInstitution" name="logo_project" id="logo_project" class="form-input" style='display: none;'>
                </div>
              </div>

              <br>
              <br>
              <div class="form-group">
                <label for="terms" class="col-sm-8 control-label file-uploader">
                  <i class="fas fa-cloud-upload-alt"> Archivo de términos y condiciones
                    <span v-html="termsAndConditions"></span>
                  </i>
                </label>
                <div class="col-sm-12">
                    <input
                      type="file"
                      accept="application/pdf"
                      enctype="multipart/form-data"
                      @change="loadTermsConditions"
                      name="terms"
                      id="terms"
                      class="form-input" style='display: none;'>
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
  </div>
</template>

<script>
  export default {
    components: {
      Multiselect
    },
    props: {
       showDeleteAndUpdateButton: Number,
    },
    data(){
      return{
        form: new Form ({
          id:"",//Project ID
          name:"", //Project name
          logo_project:"", //Project's logo
          logo_sponsor:"", //Sponsor's logo
          logo_auxiliar:"", //Auxiliar's logo
          longitud:"", // ubicación
          latitud:"", // ubicación
          actividad_economica:"", // actividad económica
          terms_connditions:""
        }),
        level: new Form({
          id:"", //level projectID
          levels:"",
          project_id:""
        }),
        project_id:0,
        title:"Agregar nuevo proyecto", //title to show
        title_level:"Agregar nuevo nivel",
        update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
        loadLogoProject:"",
        loadLogoSponsor:"",
        loadLogoAuxiliar:"",
        termsAndConditions:"",
        Projects:{}, //All registered projects
        Economics:{},
        datos:{},
        value: [
          { name: 'Gratuito', code: 'GR' }
        ],
        options: [
            { name: 'Premium', code: 'PR' },
            { name: 'Estudiante', code: 'ES' },
            { name: 'Gratuito', code: 'GR' }
          ]
      }
    },
    methods:{
      getProjectsPaginator(page = 1) {
        axios.get('/proyectos?page=' + page)
        .then(response => {
              this.Projects = response.data; //get all projects from page
        });
      },
      getLogo(project){
          let logo = (project.logo_project.length > 200) ? project.logo_project : "/img/profile-prj/"+ project.logo_project ;
          return logo;
      },
      loadLogoOrganization(f){
          let file = f.target.files[0];
          let reader = new FileReader();
          if (this.validateFile(file)){
            this.loadLogoProject ='<i class="far fa-check-circle"></i> ';
            reader.onloadend = (file) => {
                this.form.logo_project = reader.result;
            }
            reader.readAsDataURL(file);
          }
      },
      loadLogoInstitution(f){
          let file = f.target.files[0];
          let reader = new FileReader();
          if (this.validateFile(file)){
            this.loadLogoSponsor ='<i class="far fa-check-circle"></i> ';
            reader.onloadend = (file) => {
                this.form.logo_sponsor = reader.result;
            }
            reader.readAsDataURL(file);
          }
      },
      loadTermsConditions(f){
        let file = f.target.files[0];
        let reader = new FileReader();
        this.termsAndConditions ='<i class="far fa-check-circle"></i> ';
        reader.onloadend = (file) => {
            this.form.terms_connditions = reader.result;
        }
        reader.readAsDataURL(file);
      },

      loadLogoAuxInstitution(e){
          let file = e.target.files[0];
          let reader = new FileReader();
          if (this.validateFile(file)){
            this.loadLogoAuxiliar ='<i class="far fa-check-circle"></i> ';
            reader.onloadend = (file) => {
                this.form.logo_auxiliar = reader.result;
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
          let me =this
          this.form.post('/proyectos/guardar')
          .then(function (response) {
              toast.fire({
                type: 'success',
                title: 'Proyecto agregado con éxito'
              });
              me.form.reset();
              me.getProjects();// show all projetcs
              me.saveLevel(response.data);
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
          me.form.id = project.id
          me.form.name = project.name
          me.form.logo_project = project.logo_project
          me.form.logo_sponsor = project.logo_sponsor
          me.form.logo_auxiliar = project.logo_auxiliar
          me.form.latitud = project.latitude
          me.form.longitud = project.longitude
          me.form.actividad_economica = project.economic_activity
          me.form.terms_connditions = project.terms_connditions

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
              me.deleteLevelStructure(project.id);
              swal.fire(
                'Eliminado',
                'Proyecto fue eliminado',
                'success'
              );
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
          me.loadLogoProject =''
          me.loadLogoSponsor=''
          me.loadLogoAuxiliar=''
          me.termsAndConditions=''
          me.title= "Agregar nuevo proyecto"
          me.update = 0;
          me.form.reset();
          me.value= [];
      },
      saveLevel(project){
        let me =this;
        me.level.project_id = project.id;
        me.level.levels = JSON.stringify({
          name:'Estructura de niveles',
          level:0,
          numGoals:0,
          goals:[],
          macroprocess:[],
          userFunctions:[],
		  relatedGoals:[]
        });
        this.level.post('/estructura/guardar')
        .then(function (response) {
            me.level.reset();
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      LoadCatalogEconomics() {
        axios.get('catalogo?id=ECONOMICS')
        .then(response => {
              this.Economics = response.data; //get all catalogs from category selected
        });
      },
      deleteLevelStructure(id){
        axios.delete('/estructura/borrar/'+ id)
        .then(function (response) {
        })
        .catch(function (error) {
            console.log(error);
        });
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
     this.getProjects()
     this.LoadCatalogEconomics()
    }
  }
</script>
