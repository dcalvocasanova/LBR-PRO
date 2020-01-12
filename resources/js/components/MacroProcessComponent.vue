<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="row">
              <div class="col-md-8">
                  <h3 class="card-title mt-0">MACROPROCESOS</h3>
              </div>
              <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo macroprocesos">
                <button class="btn btn-primary"
                data-toggle="modal"
                data-target="#addMacroprocess">
                  <i class="fa fa-plus-circle"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th style="width:90%"> Nombre </th>
                    <th style="width:10%"> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="macroprocess in Macroprocesss.data" :key="macroprocess.id">
                      <td v-text="macroprocess.name"></td>
                      <td>
                        <button class="btn btn-info btn-sm"
                          @click="loadFieldsUpdate(macroprocess)"
                          data-toggle="modal"
                          data-target="#addMacroprocess">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm"
                         @click="deleteMacroprocess(macroprocess)">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm"
                        @click="showLevels(macroprocess)">
                          <i class="far fa-eye"></i>
                        </button>

                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Macroprocesss" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
      <div class="col-md-8">
          <levels v-if="this.showLevel != '0'" v-bind:key="componentLevelKey"/>
      </div>
    </div>
    <div class="modal fade" id="addMacroprocess" tabindex="-1" role="dialog" aria-labelledby="MacroprocessModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="MacroprocessModalLabel">Niveles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ title }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.nombre" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                          <has-error :form="form" field="nombre"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="update== 0" @click="saveMacroprocess()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateMacroprocess()" class="btn btn-info">Actualizar</button>
                        <button v-if="update!= 0" @click="salir()" class="btn btn-secondary">Atrás</button>
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
                  id:"",//User ID
                  nombre:""
                }),
                componentLevelKey:0,
                componentObjectiveKey:0,
                title:"Agregar nuevo macroprocesos", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                showLevel:0,
                showObjective:0,
                Macroprocesss:{}, //BD content
                Macroprocess:{}
            }
        },
        methods:{
            getResults(page = 1) {
              axios.get('/macroprocesos?page=' + page)
              .then(response => {
                    this.Macroprocesss = response.data; //get all projects from page
              });
            },
            showLevels(macroprocess){
              let me =this;
              me.showLevel= macroprocess.id;
              me.Macroprocess =macroprocess;
              axios.post('/macroprocesos/setsession',{
                id: macroprocess.id,
                name: macroprocess.name
              })
              .then(function (response) {
                me.componentLevelKey += 1;
              })
              .catch(function (error) {
                console.log(error);
              });
            },
            getMacroprocesos(){
                let me =this;
                me.clearFields();
                axios.get('/macroprocesos').then(function (response) {
                    me.Macroprocesss = response.data; //get all macroprocesss
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveMacroprocess(){
                let me =this;
                this.form.post('/macroprocesos/guardar')
                .then(function (response) {
                    me.salir();
                    me.getMacroprocesos();// show all users
                    toast.fire({
                      type: 'success',
                      title: 'Macroproceso registrado con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateMacroprocess(){
                let me = this;
                this.form.put('/macroprocesos/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Parámetro actualizado con éxito'
                   });
                   $('#addMacroprocess').modal('toggle');
                   me.getMacroprocesos();
                   me.salir();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(macroprocess){
              let me =this;
              me.update = macroprocess.id
              me.title="Actualizar información del macroprocesos";
              me.form.nombre = macroprocess.name;
              me.form.id = macroprocess.id;
            },
            deleteMacroprocess(macroprocess){
              let me =this;
              swal.fire({
                title: 'Eliminar un lista de macroprocesos',
                text: "Esta acción no se puede revertir, Está a punto de eliminar un macroprocesos",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarlo!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/macroprocesos/borrar/'+macroprocess.id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Parametro fue eliminado',
                      'success'
                    )
                    me.getMacroprocesos();
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
                }
              })
            },
            clearFields(){
                let me =this;
                me.title="Agregar nuevo macroprocesos",
                me.update = 0;
                me.form.reset();
            },
            salir(){
              this.clearFields();
              $('#addMacroprocess').modal('toggle');
            }

        },
        mounted() {
           this.getMacroprocesos();
        }
    }
</script>
