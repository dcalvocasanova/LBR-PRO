<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="row">
              <div class="col-10">
                  <h3 class="card-title mt-0"> Criterios de evaluación</h3>
              </div>
              <div class="col-2" @click="addNewCriteria()" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo criterio">
                <button class="btn btn-primary"
                data-toggle="modal">
                  <i class="fa fa-plus-circle"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body card-body-fitted ">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th style="width:90%"> Nombre </th>
                    <th style="width:10%"> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="criteria in Criterias.data" :key="criteria.id">
                      <td v-text="criteria.name"></td>
                      <td>
                        <button class="btn-icon btn btn-info"
                          @click="loadFieldsUpdate(criteria)"
                          data-toggle="modal"
                          data-target="#addQuestion">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn btn-info"
                          @click="loadCriteria(criteria)"
                          data-toggle="modal"
                          data-target="#addValueScale">
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                        <button class="btn-icon btn btn-danger"
                         @click="deleteQuestion(criteria)">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Criterias" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="QuestionModalLabel">Criterio de evaluación</h5>
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
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Criterios</label>
                          <multiselect
                            v-model="Categories"
                            noOptions="Escriba el nuevo criterio"
                            tag-placeholder="Agregar categoría"
                            placeholder=""
                            label="name"
                            track-by="code"
                            selectedLabel=''
                            deselectLabel='presione enter para eliminar'
                            :options="Categories"
                            :multiple="true"
                            :taggable="true"
                            :class="{ 'is-invalid': form.errors.has('categories')}"
                            @input="addDefaltValue"
                            @tag="addTag">
                          </multiselect>

                          <has-error :form="form" field="categories"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="update== 0" @click="saveQuestion()" class="btn btn-success">Añadir</button>
                        <button v-if="update!= 0" @click="updateQuestion()" class="btn btn-info">Actualizar</button>
                        <button v-if="update!= 0" @click="exit()" class="btn btn-secondary">Atrás</button>
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
    <div class="modal fade" id="addValueScale" tabindex="10" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="QuestionModalLabel">Escala númerica para los criterios de evaluación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div clasvs="card">
              <div class="card-body">
                <div class="form-group">
                  <label class="bmd-label-floating">Criterios</label>
                    <multiselect
                      noOptions="sin criterios"
                      tag-placeholder="selecionar"
                      placeholder="Seleccionar criterio para asignar valor numérico"
                      label="name"
                      track-by="code"
                      select-label="selecionar"
                      openDirection="below"
                      :options="Categories"
                      :multiple="false"
  			              :close-on-select="true"
                      :custom-label="customLabel"
                      @input="addDefaltValue"
                    >
                    </multiselect>
                </div>
                <div class="form-group" v-if="showFormRegistration">
                  <label for="newValue"> {{ this.currentCriteria.name}}</label>
                  <input v-model="currentCriteria.value" type="number" :placeholder="currentCriteria.value">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container-buttons">
              <button  v-if="showFormRegistration" @click="uploadBackground()" class="btn btn-info">Guardar</button>
              <button @click="exitScale()" class="btn btn-secondary">Atrás</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    Multiselect
  },
  data(){
    return{
      form: new Form ({
        id:"",//User ID
        name:"",
        categories:""
      }),
      title:"Agregar nuevo criterio", //title to show
      update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
      Criterias:{},
      Categories: [],
      showFormRegistration: false,
      currentCriteria:{}
    }
  },
  methods:{
    getResults(page = 1) {
      axios.get('/criterios-evaluacion?page=' + page)
      .then(response => {
            this.Criterias = response.data; //get all projects from page
      });
    },
    getPreguntas(page = 1){
      let me =this;
      me.clearFields()
      axios.get('/criterios-evaluacion?page=' + page).then(function (response) {
          me.Criterias = response.data; //get all Criterias
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    addNewCriteria(){
      this.clearFields()
      $('#addQuestion').modal('show');
    },
    saveQuestion(){
      let me =this;
      me.form.categories = JSON.stringify(me.Categories)
      me.form.post('/criterios-evaluacion/guardar')
      .then(function (response) {
          me.exit();
          me.getPreguntas();// show all categorys
          toast.fire({
            type: 'success',
            title: 'Criterio registrado con éxito'
          });
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    updateQuestion(){
      let me = this;
      me.form.categories = JSON.stringify(me.Categories)
      this.form.put('/criterios-evaluacion/actualizar')
      .then(function (response) {
         toast.fire({
          type: 'success',
          title: 'Criterio actualizado con éxito'
         });
         me.getPreguntas();
         me.exit();
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    uploadBackground(){
      let me = this
      if(me.validateAsNumber(me.currentCriteria.value)){
        me.form.categories = JSON.stringify(me.Categories)
        me.form.put('/criterios-evaluacion/actualizar')
        .then(function (response) {
          me.showFormRegistration = false
        })
      }else{
        toast.fire({
          type: 'error',
          title: 'El criterio debe ser numérico'
        });
      }

    },
    validateAsNumber(input)
    {
     let letters = /^[A-Za-z]+$/
     if (input.match(letters))
        return false
      return true
    },
    loadCriteria(criteria){
      let me =this
      me.form.id = criteria.id
      me.form.name = criteria.name
      me.Categories = JSON.parse(criteria.categories)
    },
    loadFieldsUpdate(criteria ){
      let me =this
      me.update = criteria.id
      me.title="Actualizar información del criterio de evaluación";
      me.form.fill(criteria)
      me.Categories =JSON.parse(criteria.categories)
    },
    deleteQuestion(criteria){
      let me =this;
      swal.fire({
        title: 'Eliminar un criterio de evaluación',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un criterio de evaluación",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/criterios-evaluacion/borrar/'+criteria.id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'El criterio fue eliminado',
              'success'
            )
            me.getPreguntas();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
      let me =this;
      me.title="Agregar nuevo criterio",
      me.update = 0;
      me.Categories= [];
      me.form.reset();
    },
    exit(){
      this.clearFields();
      $('#addQuestion').modal('toggle');
    },
    exitScale(){
      this.showFormRegistration = false
      $('#addValueScale').modal('toggle');
    },
    addDefaltValue(currentValue){
      this.showFormRegistration = true
      this.currentCriteria = currentValue
    },
    customLabel(option){
      return option.name +' con valor asignado de: '+ option.value
    },
    addTag (newTag) {
      const tag = {
        name: newTag,
        value: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      }
      this.Categories.push(tag)
    }
  },
  mounted() {
     this.getPreguntas();
  }
}
</script>

<style>
.modal-body {
  max-height: calc(100vh - 210px);
  overflow-y: auto;
}
</style>
