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
            <div class="text-center">
                <h5 class="card-title mt-1"> Lista de tareas</h5>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Por producto</label>
                      <select v-model="form.laborType" class=" form-control">
                        <option v-for="f in WorkTypes">{{ f.name }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Por nivel</label>
                      <select v-model="form.laborType" class=" form-control">
                        <option v-for="f in WorkTypes">{{ f.name }}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <input type="checkbox" v-model="tiempos"/>
                <label>Mostrar tiempos</label><br>
                <input type="checkbox" v-model="mejoramiento"/>
                <label>Mejoramiento</label>
              </div>
            </div>
          </div>
          <div class="card-body ">
            <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                    <tr><th> Tarea </th></tr>
                  </thead>
                  <tbody>
                    <tr v-for="t in Tasks.data" :key="t.id">
                      <tasks-unit
                      :task="t"
                      :showTimeOption="tiempos"
                      :showImproveOption="mejoramiento"
                      :Frecuencies="Frecuencies"
                      :WorkTypes="WorkTypes"
                      :Correlation="Correlation"
                      :AddedValue="AddedValue"
                      :Risk="Risk"
                      :RiskCondition="RiskCondition"
                      :OrganizationalSkills="OrganizationalSkills"
                      >
                    </tasks-unit>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Tasks" @pagination-change-page="getTasks"></pagination>
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
            procedure:"",
            PHVA:"",
            frecuency:"",
            t_min:"",
            t_avg:"",
            t_max:"",
            quantity:"",
            laborType:"",
            competence:"",
            effort:"",
            risk:"",
            addedValue:"",
            correlation:""
          }),
          selectingProjectToAddTasks: true,
          tiempos:true,
          mejoramiento:false,
          currentProject:0,
          showDetails: false,
          task_id:[],
          title:"Agregar nuevos elementos a las tarea", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
          showVariable:0,
          Projects:{},
          Tasks:{},
          TaskElements:{},
          PHVA:{},
          Frecuencies:{},
          WorkTypes:{},
          AddedValue:{},
          Correlation:{},
          Risk:{},
          RiskCondition:{},
          OrganizationalSkills:{}
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
          axios.get('/tareas/'+this.currentProject+'?page=' + page)
          .then(response => {
            me.Tasks = response.data
          });
        },
        setProject(){
          let me = this
          me.selectingProjectToAddTasks=false
          me.getTasks()
        },
        saveTask(){
          let me =this;
          me.form.project_id=me.currentProject
          let PHVA = JSON.stringify(me.form.PHVA)
          me.form.PHVA = PHVA
          me.form.task_id= me.task_id.toString();
          me.form.post('/tareas-elementos-asociados/guardar')
          .then(function (response) {
              me.clearFields();
              toast.fire({
                type: 'success',
                title: 'Elementos de la tarea guardados con éxito'
              });
          });
        },
        showTask(task){
          let me =this;
          me.form.fill(task);
          me.task_id = task.task_id.split(",");
          me.update = task.id
          me.title="Actualizar información de los elementos de las tareas"
          $('#TaskCatalogPicker').modal('show')
        },
        updateTask(task){
          let me = this;
          me.form.task_id= me.task_id.toString();
          me.form.put('/tareas-elementos-asociados/actualizar')
          .then(function (response) {
             toast.fire({
              type: 'success',
              title: 'Elementos de la tarea actualizado con éxito'
             });
             me.clearFields();
          })
        },
        deleteTask(task){
          let me =this;
          swal.fire({
            title: 'Eliminar configuración',
            text: "Esta acción no se puede revertir, Está a punto de eliminar elementos de tareas",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#114e7e',
            cancelButtonColor: '#20c9a6',
            confirmButtonText: '¡Sí, eliminarlo!'
          })
          .then((result) => {
            if (result.value) {
              axios.delete('/tareas-elementos-asociados/borrar/'+task.id)
              .then(function (response) {
                swal.fire(
                  'Eliminado',
                  'Configuración fue eliminada',
                  'success'
                )
              })
            }
          })
        },
        clearFields(){
          let me =this;
          $('#TaskCatalogPicker').modal('toggle')
          me.title= "Agregar nuevos elementos a las tareas";
          me.update = 0
          me.task_id =[]
          me.form.reset()
        },
        LoadCatalogFrecuency() {
          axios.get('catalogo?id=FRECUENCY')
          .then(response => {
                this.Frecuencies = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogWorkType() {
          axios.get('catalogo?id=WORKTYPE')
          .then(response => {
                this.WorkTypes = response.data; //get all catalogs from category selected
          });
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
        this.LoadCatalogFrecuency();
        this.LoadCatalogWorkType();
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
