<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-6">
        <div class="text-center" @click="loadCategory(0)">
          <img src="/img/site/workload.png" style="height:30%;width:50%;"class="avatar img-circle img-thumbnail" alt="avatar">
          <br>
          <label class="bmd-label-floating">Generar estudio de cargas de trabajo</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="text-center" @click="loadCategory(1)">
          <img src="/img/site/psychosocial.png" style="height:30%;width:50%;" class="avatar img-circle img-thumbnail" alt="avatar">
          <br>
          <label class="bmd-label-floating">Generar análisis psicosocial</label>
        </div>
      </div>
      <!-- <div class="col-md-3">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="row">
              <div class="col-md-8">
                  <h3 class="card-title mt-0"> Lista de parámetros</h3>
              </div>
              <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo parámetro">
                <button class="btn btn-primary"
                data-toggle="modal"
                data-target="#addParameter">
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
                    <tr v-for="parameter in Parameters.data" :key="parameter.id">
                      <td v-text="parameter.name"></td>
                      <td>
                        <button class="btn btn-info btn-sm"
                          @click="loadFieldsUpdate(parameter)"
                          data-toggle="modal"
                          data-target="#addParameter">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm"
                         @click="deleteParameter(parameter)">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm"
                        @click="showSubparameters(parameter)">
                          <i class="far fa-eye"></i>
                        </button>

                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Parameters" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
      <div class="col-md-8">
          <subparameters v-if="this.showSubparameter != '0'" v-bind:key="componentSubParameterKey"/>
      </div>
    -->
    </div>
    <div class="modal fade" id="addParameter" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ParameterModalLabel">Parámetros</h5>
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
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.nombre" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                          <has-error :form="form" field="nombre"></has-error>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Tipo</label>
                          <select v-model="form.tipo" class=" form-control" :class="{ 'is-invalid': form.errors.has('tipo')}">
                            <option value="workload">Cargas de trabajo</option>
                            <option value="psychosocial">Análisis Psicosocial</option>
                          </select>
                          <has-error :form="form" field="tipo"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="update== 0" @click="saveParameter()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateParameter()" class="btn btn-info">Actualizar</button>
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
                  nombre:"",
                  tipo:""
                }),
                componentSubParameterKey:0,
                componentVariableKey:0,
                title:"Agregar nuevo parámetro", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                showSubparameter:0,
                showVariable:0,
                Parameters:{}, //BD content
                Parameter:{}
            }
        },
        methods:{
            loadCategory(param){
              if (param === 0){
                  alert ('Cargas de trabajo');
              }else{
                  alert ('Analisis psicosocial');
              }

            },
            getResults(page = 1) {
              axios.get('/parametros?page=' + page)
              .then(response => {
                    this.Parameters = response.data; //get all projects from page
              });
            },
            showSubparameters(parameter){
              let me =this;
              me.showSubparameter= parameter.id;
              me.Parameter =parameter;
              axios.post('/parametros/setsession',{
                id: parameter.id,
                name: parameter.name
              })
              .then(function (response) {
                me.componentSubParameterKey += 1;
              })
              .catch(function (error) {
                console.log(error);
              });
            },
            getParametros(){
                let me =this;
                me.clearFields();
                axios.get('/parametros').then(function (response) {
                    me.Parameters = response.data; //get all parameters
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveParameter(){
                let me =this;
                this.form.post('/parametros/guardar')
                .then(function (response) {
                    me.salir();
                    me.getParametros();// show all users
                    toast.fire({
                      type: 'success',
                      title: 'Parámetro registrado con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateParameter(){
                let me = this;
                this.form.put('/parametros/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Parámetro actualizado con éxito'
                   });
                   $('#addParameter').modal('toggle');
                   me.getParametros();
                   me.salir();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(parameter){
              let me =this;
              me.update = parameter.id
              me.title="Actualizar información del parámetro";
              me.form.nombre = parameter.name;
              me.form.tipo = parameter.type;
              me.form.id = parameter.id;
            },
            deleteParameter(parameter){
              let me =this;
              swal.fire({
                title: 'Eliminar un lista de parámetro',
                text: "Esta acción no se puede revertir, Está a punto de eliminar un parámetro",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarlo!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/parametros/borrar/'+parameter.id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Parametro fue eliminado',
                      'success'
                    )
                    me.getParametros();
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
              $('#addParameter').modal('toggle');
            }

        },
        mounted() {
           this.getParametros();
        }
    }
</script>
