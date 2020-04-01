<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddUsers === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se gestionaran usuarios</h4>
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
    <div class="row" v-if="this.selectingProjectToAddUsers === false">
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
            <div class="col-md-6">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Nombre </th>
                    <th> Opciones </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="task in Tasks" :key="task.id">
                    <td v-text="task.name"></td>
                    <td>
                    </td>
                  </tr>
                </tbody>
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
            <h5 class="modal-title" id="TaskManager"> Funciones de usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-12">
                    <div class="row">
                      <div class="users-and-goals col-md-6">
                        <table class="table table-hover">
                         <thead>
                            <tr><th>Funciones de usuario a emplear</th></tr>
                          </thead>
                          <tbody>
                            <tr v-for="f in UserFunctions" :key="f[0]" >
                              <td> >
                                <span v-text="f[0]"></span>
                                <span v-text="f[2]"></span>
                              </td>

                            </tr>

                          </tbody>
                        </table>
                      </div>
                      <div class="user-functions col-md-6">
                        <div class="form-group">


                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="container-buttons">
                    <button v-if="update== 0" @click="addUserFunction()" class="btn btn-success">Añadir</button>
                    <button v-if="update!= 0" @click="updateUserFunction()" class="btn btn-info">Actualizar</button>
                    <button @click="exitEditorUserFunctions()" class="btn btn-secondary">Salir sin guardar</button>
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
          currentProject:0,
          showDetails: false,
          selectingProjectToAddUsers: true,
          title:"Agregar nueva categoría de parámetro ", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
          Projects:{},
          Users:{},
          showVariable:0,
          Frecuencies:{},
          WorkTypes:{},
          UserFunctions:{},
          Tasks:[
            {
              id:1,
              name: "tarea 1",
              inventory: 5,
              unit_price: 45.99
            },
            {
              id:2,
              name: "tarea 2",
              inventory: 10,
              unit_price: 123.75
            },
            {
              id:3,
              name: "tarea 3",
              inventory: 2,
              unit_price: 399.50
            }
          ]
        }
      },
      methods:{
        detalle(){
          swal.fire(
            'Por el momento no tenemos Macroprocesos registrados',
            '¡Muy pronto tendremos la funcionalidad implementada!',
            'warning'
          )
        },
        getUserFunctions() {
          axios.get('/estructura/lista-funciones-de-usuario/'+this.currentProject)
          .then(response => {
              this.UserFunctions = response.data; //get all projects from page.
          });
        },
        setProject(){
          let me = this
          me.selectingProjectToAddUsers=false
          me.getUserFunctions()
        },
        getProjectos(){
          let me =this;
          axios.get('/todos-los-proyectos')
          .then(response => {
              me.Projects = response.data; //get all projects from page
          });
        }
      },
      mounted() {
        this.getProjectos()
      }
}
</script>
