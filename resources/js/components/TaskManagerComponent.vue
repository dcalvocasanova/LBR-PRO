<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddTasks === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se gestionaran las tareas</h4>
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
            <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva variable">
              <button class="btn btn-primary"
              data-toggle="modal"
              data-target="#TaskManager"
              >
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="card-body card-body-fitted ">
            <div class="col-12">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Tarea </th>
                    <th> Opciones </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="t in Tasks.data" :key="t.id">
                    <td v-text="t.task"></td>
                    <td>
                      <button class="btn btn-info" @click="loadFieldsUpdate(t)"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-danger" @click="deleteTask(t)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>
                </tbody>
                <div class="footer">
                  <pagination :data="Tasks" @pagination-change-page="getTasks"></pagination>
                </div>
              </table>
            </div>
          </div>
          <div class="card-footer">

          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="TaskManager" tabindex="-1" role="dialog" aria labelledby="TaskManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="TaskManager"> {{ title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4">
                <button class="btn btn-primary btn-block"
                  @click="loadCatalog('PRODUCT')">
                  Productos
                </button>
                <button class="btn btn-primary btn-block"
                  @click="loadCatalog('SUB-PRODUCT')">
                  Sub productos
                </button>
                <button class="btn btn-primary btn-block"
                  @click="loadCatalog('USER-FUNCTION')">
                  Funciones de usuario
                </button>
              </div>
              <div class="col-8">
                <div class="row">
                  <div class="col-12">
                    <div class="card mb-3 py-0 border-bottom-danger">
                      <div class="card-body" >
                         <input style="width:100%" v-model="form.allocator" type="text" :class="{'is-invalid': form.errors.has('allocator') }" disabled>
                         <has-error :form="form" field="allocator"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">Nombre de la tarea</label>
                      <input v-model="form.task" type="text" class="form-control":class="{'is-invalid': form.errors.has('task') }">
                      <has-error :form="form" field="task"></has-error>
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
            <button v-if="update != 0" @click="exit()" class="btn btn-secondary">Atrás</button>
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
                              <span style="width:100%" class="process" v-if="currentTypeTaks=='PRODUCT'">
                                <tr v-for="p in Products.process" :key="p.id" >
                                  <td @click="optionPicker(p)">
                                    <span v-text="p.file">:</span>
                                    <span v-text="p.resultProduct"></span>
                                  </td>
                                </tr>
                              </span>
                              <span class="sub-process" v-if="currentTypeTaks=='SUB-PRODUCT'">
                                <tr v-for="s in Products.subprocess" :key="s.id" >
                                  <td colspan="12" @click="optionPicker(s)" >
                                    <span v-text="s.process"></span>
                                    <span v-text="s.product"></span>
                                  </td>
                                </tr>
                              </span>
                              <span class="funcions" v-if="currentTypeTaks=='USER-FUNCTION'">
                                <tr v-for="f in UserFunctions" :key="f[0]">
                                  <td colspan="12" @click="optionPicker(f)" >
                                    <span v-text="f[2]"></span>
                                    <span v-text="f[0]"></span>
                                  </td>
                                </tr>
                              </span>
                            </tbody>
                          </table>
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
            id_project:0,
            id_product:0,
            relatedToLevel:"",
            allocator:"",
            task:"",
            type:""
          }),
          currentProject:0,
          currentTypeTaks:"",
          currentSelectedItem:"",
          selectingProjectToAddTasks: true,
          title:"Agregar nueva tarea ", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
          Projects:{},
          Tasks:{},
          Products:{},
          UserFunctions:{}
        }
      },
      methods:{
        getUserFunctions() {
          axios.get('/estructura/lista-funciones-de-usuario/'+this.currentProject)
          .then(response => {
              this.UserFunctions = response.data; //get all projects from page.
          });
        },
        getProducts() {
          axios.get('/proyecto/productos/'+this.currentProject)
          .then(response => {
              this.Products = response.data; //get all projects from page.
          });
        },
        getTasks(page = 1) {
          let me =this;
          me.clearFields();
          axios.get('/tareas/'+this.currentProject+'?page=' + page)
          .then(response => {
            me.Tasks = response.data
          });
        },
        setProject(){
          let me = this
          me.selectingProjectToAddTasks=false
          me.getUserFunctions()
          me.getProducts()
          me.getTasks()
        },
        getProjectos(){
          let me =this;
          axios.get('/todos-los-proyectos')
          .then(response => {
              me.Projects = response.data; //get all projects from page
          });
        },
        loadCatalog(type){
          let me =this
          me.currentTypeTaks = type
          $('#TaskCatalogPicker').modal('show');

        },
        loadFieldsUpdate(task){
          let me =this;
          me.form.fill(task)
          me.update = task.id
          me.currentSelectedItem = task.allocator
          me.title="Actualizar información de la tarea";
          $('#TaskManager').modal('show');

        },
        optionPicker(type){
          let me =this
          if(me.currentTypeTaks =='PRODUCT'){
            me.form.id_project = type.project_id
            me.form.id_product = type.id
            me.form.allocator = type.resultProduct
            me.form.relatedToLevel = type.relatedToLevel
            me.form.type = 'PRODUCT'
          }
          if(me.currentTypeTaks =='SUB-PRODUCT'){
            me.form.id_project = type.project_id
            me.form.id_product = type.id
            me.form.allocator = type.product
            me.form.relatedToLevel = type.relatedToLevel
            me.form.type = 'SUB-PRODUCT'
          }
          if(me.currentTypeTaks =='USER-FUNCTION'){
            me.form.id_project = me.currentProject
            me.form.id_product = 0
            me.form.allocator = type[0]
            me.form.relatedToLevel = type[2]
            me.form.type = 'USER-FUNCTION'
          }
          $('#TaskCatalogPicker').modal('toggle');
        },
        saveTask(){
          let me =this;
          me.form.post('/tareas/guardar')
          .then(function (response) {
              me.exit()
              me.getTasks();// show all task
              toast.fire({
                type: 'success',
                title: 'Tarea registrada con éxito'
              });
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        updateTask(){
          let me = this;
          this.form.put('/tareas/actualizar')
          .then(function (response) {
             toast.fire({
              type: 'success',
              title: 'Tarea actualizada con éxito'
             });
             me.exit()
             me.getTasks()
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        deleteTask(task){
          let me =this;
          swal.fire({
            title: 'Eliminar una tarea',
            text: "Esta acción no se puede revertir, Está a punto de eliminar una tarea",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#114e7e',
            cancelButtonColor: '#20c9a6',
            confirmButtonText: '¡Sí, eliminarla!'
          })
          .then((result) => {
            if (result.value) {
              axios.delete('/tareas/borrar/'+task.id)
              .then(function (response) {
                swal.fire(
                  'Eliminada',
                  'Tarea fue eliminada',
                  'success'
                )
              })
              .catch(function (error) {
                  console.log(error);
              });
              this.getTasks();
            }
          })
        },
        clearFields(){
          let me =this;
          me.update = 0;
          me.form.reset();
        },
        exit(){
          this.clearFields()
          $('#TaskManager').modal('toggle');
        }
      },
      mounted() {
        this.getProjectos()
      }
}
</script>
