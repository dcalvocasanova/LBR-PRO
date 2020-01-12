<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="col-md-8">
                <h3 class="card-title mt-0"> Lista de Objectivos</h3>
            </div>
            <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva Objectivo">
              <button class="btn btn-primary"
              data-toggle="modal"
              data-target="#addObjective">
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th style="width: 92px;"> Nombre </th>
                    <th> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr  v-for="Objective in Objectives.data" :key="Objective.id">
                      <td v-text="Objective.name"></td>
                      <td>
                        <button class="btn btn-info"
                          @click="loadFieldsUpdate(Objective)"
                          data-toggle="modal"
                          data-target="#addObjective">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" @click="deleteObjective(Objective)"><i class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Objectives" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addObjective" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ParameterModalLabel">Objectivos</h5>
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
                          <select v-model="form.tipo" class="form-control" :class="{ 'is-invalid': form.errors.has('tipo') }">
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
                          <select v-model="form.regla" class="form-control" :class="{ 'is-invalid': form.errors.has('medida') }">
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
                        <button v-if="update== 0" @click="saveObjective()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateObjective()" class="btn btn-info">Actualizar</button>
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
                  tipo:"",
                  valor:"",
                  medida:"",
                  rule:""
                }),
                showDetails: true,
                componentObjectiveKey:0,
                title:"Agregar nueva categoría de parámetro ", //title to show
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                showObjective:0,
                Objectives:{}, //BD content
                Objective:{}
            }
        },
        methods:{
            getResults(page = 1) {
              axios.get('/Objectives?page=' + page)
              .then(response => {
                    this.Objective = response.data; //get all projects from page
              });
            },
            showSubObjectives(Objective){
              let me =this;
              me.showObjective= Objective.id;
              me.Objective =Objective;
              axios.post('/Objectives/setsession',{
                id: parameter.id,
                name: parameter.name
              })
              .then(function (response) {
                me.componentObjectiveKey += 1;
              })
              .catch(function (error) {
                console.log(error);
              });
            },
            getVaraibles(){
                let me =this;
                me.clearFields();
                axios.get('/Objectives')
                .then(function (response) {
                    me.Objectives = response.data; //get all parameters
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveObjective(){
                let me =this;
                this.form.post('/Objectives/guardar')
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
            updateObjective(){
                let me = this;
                this.form.put('/Objectives/actualizar')
                .then(function (response) {
                   toast.fire({
                    type: 'success',
                    title: 'Objective actualizada con éxito'
                   });
                   $('#addObjective').modal('toggle');
                   me.getVaraibles();
                   me.salir();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(Objective){
              let me =this;
              me.update = Objective.id
              me.title="Actualizar información de la Objective";
              me.form.nombre = Objective.name;
              me.form.tipo = Objective.type;
              me.form.id = Objective.id;
            },
            deleteObjective(Objective){
              let me =this;
              swal.fire({
                title: 'Eliminar un Objectivo',
                text: "Esta acción no se puede revertir, Está a punto de eliminar una Objectivo",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#114e7e',
                cancelButtonColor: '#20c9a6',
                confirmButtonText: '¡Sí, eliminarla!'
              })
              .then((result) => {
                if (result.value) {
                  axios.delete('/Objectives/borrar/'+Objective.id)
                  .then(function (response) {
                    swal.fire(
                      'Eliminado',
                      'Objectivo fue eliminado',
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
                me.title="Agregar nueva Objective",
                me.update = 0;
                me.form.reset();
            },
            salir(){
              this.clearFields();
              $('#addObjective').modal('toggle');
            }

        },
        mounted() {
           this.getVaraibles();
        }
    }
</script>
