<template>
  <div class="container container-project">
    <div class="row">
        <div class="col-md-12">
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
                      <th> Logo </th>
                      <th> Niveles de estructura </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="project in Projects.data" :key="project.id" >
                        <td v-text="project.name"></td>
                        <td style="width: 80px;"> <img  class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                        <td>
                            <button class="btn btn-primary" @click="loadLevelData(project)" data-toggle="modal" data-target="#addLevels"><i class="fas fa-swatchbook"> Niveles de estructura</i></button>
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
      </div>
    <div class="modal fade" id="addLevels" tabindex="-1" role="dialog" aria-labelledby="LevelModalOptions-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="LevelModalOptions">Niveles de estructura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <button @click="saveLevel()" class="btn btn-success">Guardar estructura</button>
            <div class="card">
              <div class="card-body">
                <div class="row">

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
        level: new Form({
          id:"", //level projectID
          levels:"",
          project_id:""
        }),
        project_id:0,
        update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
        Projects:{}, //All registered projects
        Levels:{} // All level from organization
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
      getProjects(){
        let me =this;
        axios.get('/proyectos').then(function (response) {
            me.Projects = response.data; //get all projects
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
      getResultLevel(page = 1){
        axios.get('/estructura?page=' + page)
        .then(response => {
              this.Levels = response.data; //get all projects from page
        });
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
      clearFieldsLevel(){
          let me =this;
          me.title_level= "Agregar nuevo nivel";
          me.updateLevelId = 0;
          me.level.reset();
      },
      loadLevelData(project){
          this.clearFieldsLevel();
          this.projet_name= project.nombre;
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
