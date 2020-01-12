<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-5">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="row">
              <div class="col-md-8">
                  <h3 class="card-title mt-0">Lista de Niveles</h3>
              </div>
              <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva categoría">
                <button class="btn btn-primary"
                data-toggle="modal"
                data-target="#addLevel">
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
                    <th style="width: 160px;"> Nombre </th>
                    <th> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr  v-for="Level in Levels.data" :key="Level.id">
                      <td v-text="Level.name"></td>
                      <td>
                        <button class="btn btn-info btn-sm"
                          @click="loadFieldsUpdate(Level)"
                          data-toggle="modal"
                          data-target="#addLevel">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="deleteLevel(Level)"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-secondary btn-sm" @click="showSubVariables(Level)"><i class="far fa-eye"></i></button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Levels" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
      <div class="col-md-7">
            <variables v-if="this.showVariable != '0'" v-bind:key="componentVariableKey"/>
      </div>
    </div>

    <div class="modal fade" id="addLevel" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ParameterModalLabel">Subparámetros</h5>
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
                        <button v-if="update== 0" @click="saveLevel()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateLevel()" class="btn btn-info">Actualizar</button>
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
                componentVariableKey:0,
                title:"Agregar nuevo nivel de estructura ", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                showVariable:0,
                Levels:{}, //BD content
                Level:{}
            }
        },
        methods:{
            getResults(page = 1) {
              axios.get('/niveles?page=' + page)
              .then(response => {
                    this.Levels = response.data; //get all projects from page
              });
            },
            showSubVariables(Level){
              let me =this;
              me.showVariable= Level.id;
              me.Level =Level;
              axios.post('/niveles/setsession',{
                id:Level.id,
                name: Level.name
              })
              .then(function (response) {
                me.componentVariableKey += 1;
              })
              .catch(function (error) {
                console.log(error);
              });
            },
            getLevels(){
                let me =this;
                me.clearFields();
                axios.get('/niveles')
                .then(function (response) {
                    me.Levels = response.data; //get all parameters
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveLevel(){
                let me =this;
                this.form.post('/niveles/guardar')
                .then(function (response) {
                    me.salir();
                    me.getLevels();// show all users
                    toast.fire({
                      type: 'success',
                      title: 'Nivel registrado con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateLevel(){
                let me = this;
                this.form.put('/niveles/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Nivel actualizado con éxito'
                   });
                   $('#addLevel').modal('toggle');
                   me.getLevels();
                   me.salir();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(Level){
              let me =this;
              me.update = Level.id
              me.title="Actualizar información del nivel";
              me.form.nombre = Level.name;
              me.form.id = Level.id;
            },
            deleteLevel(Level){
              let me =this;
              swal.fire({
                title: 'Eliminar un nivel',
                text: "Esta acción no se puede revertir, Está a punto de eliminar un nivel",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarlo!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/niveles/borrar/'+Level.id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Parametro fue eliminado',
                      'success'
                    )
                    me.getLevels();
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
                }
              })
            },
            clearFields(){
                let me =this;
                me.title="Agregar nuevo parámetro",
                me.update = 0;
                me.form.reset();
            },
            salir(){
              this.clearFields();
              $('#addLevel').modal('toggle');
            }

        },
        mounted() {
           this.getLevels();
        }
    }
</script>
