<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddTasks === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se gestionaran las tareas y procedimientos asociados</h4>
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
    <div class="row" v-if="this.selectingProjectToAddTasks === false">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="col-md-8">
                <h3 class="card-title mt-0"> Lista de tareas</h3>
            </div>
            <div class="col-md-4"
              data-toggle="modal"
              data-target="#TaskCatalogPicker">
              <button class="btn btn-primary">
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="card-body card-body-fitted ">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Procedimiento </th>
                    <th> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="task in Tasks.data" :key="task.id">
                      <td v-text="task.task"></td>
                    </tr>
                  </tbody>
              </table>
            </div>
            <div class="col-md-6">

            </div>

          </div>
          <div class="card-footer">

          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="TaskCatalogPicker" tabindex="-1" role="dialog" aria labelledby="TaskCatalogPicker-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="TaskCatalogPicker"> Opciones disponibles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-5">
                <div class="card">
                  <div class="card-body">
                    <div class="col-12">
                      <div class="row">
                        <div class="users-and-goals">
                          <table class="table table-hover">
                           <thead>
                              <th>Funciones de usuario a emplear</th>
                            </thead>
                            <tbody>


                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="card">
                  <div class="card-body">
                    <div class="col-12">
                      <div class="row">
                        aca el contenido
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
                id:"",
                name:"",
                type:""
              }),
              selectingProjectToAddTasks: true,
              currentProject:0,
              showDetails: false,
              title:"Agregar nueva categoría de parámetro ", //title to show
              update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
              showVariable:0,
              Projects:{},
              AddedValue:{},
              Correlation:{},
              Risk:{},
              RiskCondition:{},
              OrganizationalSkills:{},
              SpecificSkills:{},
              TecnicalSkills:{},
              Tasks:{}
          }
      },
      methods:{
        getProjects(){
          let me =this;
          axios.get('/todos-los-proyectos')
          .then(response => {
              me.Projects = response.data; //get all projects from page
          });
        },
        getTasks(page = 1) {
          let me =this;
          axios.get('/tareas/'+this.currentProject)
          .then(response => {
            me.Tasks = response.data
          });
        },
        setProject(){
          let me = this
          me.selectingProjectToAddTasks=false
          me.getTasks()
        },        
        LoadCatalogAddedValued() {
          axios.get('catalogo?id=ADDED-VALUED-T')
          .then(response => {
                this.AddedValue = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogCorrelation() {
          axios.get('catalogo?id=CORRELATION-T')
          .then(response => {
                this.Correlation = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogRisk() {
          axios.get('catalogo?id=RISK-T')
          .then(response => {
                this.Risk = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogRiskCondition() {
          axios.get('catalogo?id=RISK-CONDITION-T')
          .then(response => {
                this.RiskCondition = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogOrganizationalSkills() {
          axios.get('catalogo?id=ORGANIZATIONAL-SKILL-T')
          .then(response => {
                this.OrganizationalSkills = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogSpecificSkills() {
          axios.get('catalogo?id=SPECIFIC-SKILL-T')
          .then(response => {
                this.SpecificSkills = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogTecnicalSkills() {
          axios.get('catalogo?id=TECNICAL-SKILL-T')
          .then(response => {
                this.TecnicalSkills = response.data; //get all catalogs from category selected
          });
        }
      },
      mounted() {
        this.getProjects()
        this.LoadCatalogAddedValued()
        this.LoadCatalogCorrelation()
        this.LoadCatalogRisk()
        this.LoadCatalogRiskCondition()
        this.LoadCatalogOrganizationalSkills()
        this.LoadCatalogSpecificSkills()
        this.LoadCatalogTecnicalSkills()
      }
}
</script>
