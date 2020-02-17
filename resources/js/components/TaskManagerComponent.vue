<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="col-md-8">
                <h3 class="card-title mt-0"> Lista de variables</h3>
            </div>
            <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva variable">
              <button class="btn btn-primary"
              data-toggle="modal"
              data-target="#addVariable">
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="card-body card-body-fitted ">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th style="width: 160px;"> Nombre </th>
                    <th style="width: 40px;"> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr  v-for="variable in Variables.data" :key="variable.id">
                      <td v-text="variable.name"></td>
                      <td>
                        <button class="btn-icon btn btn-info"
                          @click="loadFieldsUpdate(variable)"
                          data-toggle="modal"
                          data-target="#addVariable">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn btn-danger"  @click="deleteVariable(variable)"><i class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Variables" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addVariable" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ParameterModalLabel">Variables</h5>
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
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Identificador</label>
                          <input v-model="form.identificador" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('identificador') }">
                          <has-error :form="form" field="identificador"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.nombre" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                          <has-error :form="form" field="nombre"></has-error>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Tipo</label>
                          <select @change="showExtraValidations()" v-model="form.tipo" class="form-control" :class="{ 'is-invalid': form.errors.has('tipo') }">
                            <option value="number">Númerico</option>
                            <option value="string">Texto</option>
                          </select>
                          <has-error :form="form" field="tipo"></has-error>
                        </div>
                      </div>
                    </div>
                    <div v-show="this.showDetails === true" class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Valor por defecto</label>
                          <input v-model="form.valor" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('value') }">
                          <has-error :form="form" field="valor"></has-error>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Medida</label>
                          <select v-model="form.medida" class="form-control" :class="{ 'is-invalid': form.errors.has('medida') }">
                            <option value="d">Días</option>
                            <option value="h">Horas</option>
                            <option value="m">Minutos</option>
                          </select>
                          <has-error :form="form" field="medida"></has-error>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Regla</label>
                          <select v-model="form.regla" class="form-control" :class="{ 'is-invalid': form.errors.has('regla') }">
                            <option value="divisible">No puede ser cero</option>
                            <option value="positivo">Número positivo</option>
                          </select>
                          <has-error :form="form" field="regla"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="update== 0" @click="saveVariable()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateVariable()" class="btn btn-info">Actualizar</button>
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
                  identificador:"",
                  tipo:"",
                  valor:"",
                  medida:"",
                  regla:""
                }),
                showDetails: false,
                title:"Agregar nueva categoría de parámetro ", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                showVariable:0,
                Variables:{}, //BD content
                Variable:{}
            }
        },
        methods:{
            getResults(page = 1) {
              axios.get('/variables?page=' + page)
              .then(response => {
                  this.Variables = response.data; //get all projects from page.
              });
            },
            showSubVariables(variable){
              let me =this;
              me.showVariable= variable.id;
              me.Variable =variable;
              axios.post('/variables/setsession',{
                id: parameter.id,
                name: parameter.name
              })
              .then(function (response) {
                  me.componentVariableKey += 1;
              })
              .catch(function (error) {
                console.log(error);
              });
            },
            showExtraValidations(){
              if(this.form.tipo =="number") {
                  this.showDetails= true;
              }else{
                  this.showDetails= false;
              }
            },
            getVaraibles(){
                let me =this;
                me.clearFields();
                axios.get('/variables')
                .then(function (response) {
                    me.Variables = response.data; //get all parameters
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveVariable(){
                let me =this;
                this.form.post('/variables/guardar')
                .then(function (response) {
                    me.salir();
                    me.getVaraibles();// show all users
                    toast.fire({
                      type: 'success',
                      title: 'Varaible registrada con éxito'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateVariable(){
                let me = this;
                this.form.put('/variables/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Variable actualizada con éxito'
                   });
                   $('#addVariable').modal('toggle');
                   me.getVaraibles();
                   me.salir();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(variable){
              let me =this;
              me.update = variable.id
              me.title="Actualizar información de la variable";
              me.form.nombre = variable.name;
              me.form.identificador = variable.identificator;
              me.form.tipo = variable.type;
              me.form.valor=variable.value;
              me.form.medida=variable.measure;
              me.form.regla=variable.rule;
              me.form.id = variable.id;
              if (me.form.tipo =="number"){this.showDetails= true;}
            },
            deleteVariable(variable){
              let me =this;
              swal.fire({
                title: 'Eliminar una variable',
                text: "Esta acción no se puede revertir, Está a punto de eliminar una variable",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarla!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/variables/borrar/'+variable.id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Variable fue eliminada',
                      'success'
                    )
                    me.getVaraibles();
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
                }
              })
            },
            clearFields(){
                let me =this;
                me.title="Agregar nueva variable",
                me.update = 0;
                me.form.reset();
                me.showDetails= false;
            },
            salir(){
              this.clearFields();
              $('#addVariable').modal('toggle');
            }

        },
        mounted() {
           this.getVaraibles();
        }
    }
</script>
