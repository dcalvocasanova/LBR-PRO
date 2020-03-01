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
              <div class="col-2" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo criterio">
                <button class="btn btn-primary"
                data-toggle="modal"
                data-target="#addQuestion">
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
                    <tr v-for="question in Questions.data" :key="question.id">
                      <td v-text="question.name"></td>
                      <td>
                        <button class="btn-icon btn btn-info"
                          @click="loadFieldsUpdate(question)"
                          data-toggle="modal"
                          data-target="#addQuestion">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn btn-danger"
                         @click="deleteQuestion(question)">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Questions" @pagination-change-page="getResults"></pagination>
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
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Criterios</label>
                          <multiselect
                            v-model="Categories"
                            tag-placeholder="Agregar categoría"
                            placeholder=""
                            label="name"
                            track-by="code"
                            noOptions='Escriba el nuevo criterio'
                            selectedLabel=''
                            deselectLabel='presione enter para eliminar'
                            :options="Categories"
                            :multiple="true"
                            :taggable="true"
                            :class="{ 'is-invalid': form.errors.has('categories')}"
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
      Questions:{}, //BD content
      Categories: [],
    }
  },
  methods:{
    getResults(page = 1) {
        axios.get('/criterios-evaluacion?page=' + page)
        .then(response => {
              this.Questions = response.data; //get all projects from page
        });
    },
    getPreguntas(){
      let me =this;
      me.clearFields();
      axios.get('/criterios-evaluacion').then(function (response) {
          me.Questions = response.data; //get all Questions
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    saveQuestion(){
      let me =this;
      me.form.categories = JSON.stringify(me.Categories)
      me.form.post('/criterios-evaluacion/guardar')
      .then(function (response) {
          me.salir();
          me.getPreguntas();// show all users
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
         $('#addQuestion').modal('toggle');
         me.getPreguntas();
         me.salir();
      })
      .catch(function (error) {
          console.log(error);
      });
    },
    loadFieldsUpdate(question ){
      let me =this;
      me.update = question.id
      me.title="Actualizar información del criterio de evaluación";
      me.form.fill(question)
      me.Categories =JSON.parse(question.categories)
    },
    deleteQuestion(question){
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
          axios.delete('/criterios-evaluacion/borrar/'+question.id)
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
    salir(){
      this.clearFields();
      $('#addQuestion').modal('toggle');
    },
    addTag (newTag) {
      const tag = {
        name: newTag,
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
