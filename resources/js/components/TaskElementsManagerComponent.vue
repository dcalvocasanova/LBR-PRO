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
                    <tr v-for="task in TaskElements.data" :key="task.id">
                      <td v-text="task.procedure"></td>
                      <td>
                        <button class="btn btn-info" @click="showTask(task)"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger" @click="deleteTask(task)"><i class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>
                  </tbody>
              </table>
              <div class="footer">
                <pagination :data="TaskElements" @pagination-change-page="getTaskElements"></pagination>
              </div>
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
            <h5 class="modal-title" id="TaskCatalogPicker"> {{title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-5">
                <div class="card">
                  <div class="card-body">
                    <table class="table table-hover">
                      <thead class="">
                        <tr>
                           Tarea a seleccionar
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="task in Tasks.data" :key="task.id">
                            <td>
                              <input v-model="task_id" type="checkbox" :value=task.id>
                              {{task.task}}
                            </td>

                          </tr>
                        </tbody>
                    </table>
                    <div class="footer">
                      <pagination :data="Tasks" @pagination-change-page="getTasks"></pagination>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="card">
                  <div class="card-body">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="bmd-label-floating">Procedimiento asociado</label>
                            <input type="text" v-model="form.procedure"  class="form-control":class="{ 'is-invalid': form.errors.has('procedure') }">
                            <has-error :form="form" field="procedure"></has-error>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="bmd-label-floating">Tipo Tarea</label>
                            <select v-model="form.PHVA" class=" form-control">
                              <option v-for="s in WorkTypes">{{ s.name }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Tipo de trabajo</label>
                            <select v-model="form.laborType" class=" form-control">
                              <option v-for="f in WorkTypes">{{ f.name }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Frecuencia</label>
                            <select v-model="form.frecuency" class=" form-control">
                              <option v-for="f in Frecuencies">{{ f.name }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-12">
                              <h4> Tiempos de las tareas</h4>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label class="bmd-label-floating">Menor </label>
                                <input type="text" v-model="form.t_min"  class="form-control":class="{ 'is-invalid': form.errors.has('procedure') }">
                                <has-error :form="form" field="procedure"></has-error>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label class="bmd-label-floating">Normal </label>
                                <input type="text" v-model="form.t_avg"  class="form-control":class="{ 'is-invalid': form.errors.has('procedure') }">
                                <has-error :form="form" field="procedure"></has-error>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label class="bmd-label-floating">Máximo </label>
                                <input type="text" v-model="form.t_max"  class="form-control":class="{ 'is-invalid': form.errors.has('procedure') }">
                                <has-error :form="form" field="procedure"></has-error>
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
          <div class="modal-footer">
            <div class="container-buttons">
              <button v-if="update == 0" @click="saveTask()" class="btn btn-success">Añadir</button>
              <button v-if="update != 0" @click="updateTask()" class="btn btn-info">Actualizar</button>
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
                id:"",
                project_id:"",
                task_id:"",
                procedure:"",
                PHVA:{},
                frecuency:"",
                t_min:"",
                t_avg:"",
                t_max:"",
                laborType:""
              }),
              selectingProjectToAddTasks: true,
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
              WorkTypes:{}
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
          me.getTaskElements()
        },
        getTaskElements(page = 1) {
          let me =this;
          axios.get('/tareas-elementos-asociados/'+this.currentProject+'?page=' + page)
          .then(response => {
            me.TaskElements = response.data
          });
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
              me.getTaskElements();
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
             me.getTaskElements();
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
                me.getTaskElements();
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
        }
      },
      mounted() {
        this.getProjects()
        this.LoadCatalogFrecuency();
        this.LoadCatalogWorkType();
      }
}
</script>
