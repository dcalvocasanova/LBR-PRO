<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-5">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="row">
              <div class="col-md-8">
                  <h3 class="card-title mt-0"> Lista de categorías parámetros</h3>
              </div>
              <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva categoría">
                <button class="btn btn-primary"
                data-toggle="modal"
                data-target="#addSubParameter">
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
                    <tr  v-for="subparameter in SubParameters.data" :key="subparameter.id">
                      <td v-text="subparameter.name"></td>
                      <td>
                        <button class="btn btn-info btn-sm"
                          @click="loadFieldsUpdate(subparameter)"
                          data-toggle="modal"
                          data-target="#addSubParameter">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="deleteSubParameter(subparameter)"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-secondary btn-sm" @click="showSubVariables(subparameter)"><i class="far fa-eye"></i></button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="SubParameters" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
      <div class="col-md-7">
            <variables v-if="this.showVariable != '0'" v-bind:key="componentVariableKey"/>
      </div>
    </div>

    <div class="modal fade" id="addSubParameter" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
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
                        <button v-if="update== 0" @click="saveSubParameter()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateSubParameter()" class="btn btn-info">Actualizar</button>
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
                title:"Agregar nueva categoría de parámetro ", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                showVariable:0,
                SubParameters:{}, //BD content
                SubParameter:{}
            }
        },
        methods:{
            getResults(page = 1) {
              axios.get('/subparametros?page=' + page)
              .then(response => {
                    this.SubParameters = response.data; //get all projects from page
              });
            },
            showSubVariables(subparameter){
              let me =this;
              me.showVariable= subparameter.id;
              me.SubParameter =subparameter;
              axios.post('/subparametros/setsession',{
                id:subparameter.id,
                name: subparameter.name
              })
              .then(function (response) {
                me.componentVariableKey += 1;
              })
              .catch(function (error) {
                console.log(error);
              });
            },
            getSubParametros(){
                let me =this;
                me.clearFields();
                axios.get('/subparametros')
                .then(function (response) {
                    me.SubParameters = response.data; //get all parameters
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveSubParameter(){
                let me =this;
                this.form.post('/subparametros/guardar')
                .then(function (response) {
                    me.salir();
                    me.getSubParametros();// show all users
                    toast.fire({
                      type: 'success',
                      title: 'Parámetro registrado con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateSubParameter(){
                let me = this;
                this.form.put('/subparametros/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Parámetro actualizado con éxito'
                   });
                   $('#addSubParameter').modal('toggle');
                   me.getSubParametros();
                   me.salir();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(subparameter){
              let me =this;
              me.update = subparameter.id
              me.title="Actualizar información del parámetro";
              me.form.nombre = subparameter.name;
              me.form.id = subparameter.id;
            },
            deleteSubParameter(subparameter){
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
                  axios.delete('/subparametros/borrar/'+subparameter.id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Parametro fue eliminado',
                      'success'
                    )
                    me.getSubParametros();
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
              $('#addSubParameter').modal('toggle');
            }

        },
        mounted() {
           this.getSubParametros();
        }
    }
</script>
