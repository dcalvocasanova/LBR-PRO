<template>
  <div class="container container-project">
    <div class="row">
        <div class="col-md-5">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de preguntas</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre </th>
                      <th> Acciones </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="q in Questions.data" :key="q.id">
                        <td v-text="q.question"></td>
                        <td>
                          <button class="btn btn-info" @click="loadFieldsUpdate(q)"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger" @click="deleteQuestion(q)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Questions" @pagination-change-page="getQuestions"></pagination>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ title }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating">Pregunta</label>
                    <input v-model="form.question" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('question') }">
                    <has-error :form="form" field="question"></has-error>
                  </div>
                </div>
              </div>
              <div class="container-buttons">
                <button v-if="update == 0" @click="saveQuestion()" class="btn btn-success">Añadir</button>
                <button v-if="update != 0" @click="updateQuestion()" class="btn btn-info">Actualizar</button>
                <button v-if="update != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
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
        question:""
      }),
      Questions:{},
      title:"Registrar nueva pregunta", //title to show
      update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
    }
  },
  methods:{

    getQuestions(page = 1){
      let me =this;
      me.clearFields();
      axios.get('/psicoanalisis/?page='+ page)
      .then(response => {
            me.Questions = response.data; //get all projects from page
      });
    },

    saveQuestion(){
      let me =this;
      me.form.post('/psicoanalisis/guardar')
      .then(function (response) {
          me.clearFields();
          me.getQuestions();// show all questions
          toast.fire({
            type: 'success',
            title: 'Pregunta registrada con éxito'
          });
      })
      .catch(function (error) {
          console.log(error);
      });

    },
    updateQuestion(){
        let me = this;
        me.form.put('/psicoanalisis/actualizar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Pregunta actualizada con éxito'
           });
           me.getQuestions();
           me.clearFields();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    loadFieldsUpdate(question){
      let me =this;
      me.form.fill(question);
      me.update = question.id
      me.title="Actualizar pregunta";
    },
    deleteQuestion(question){
      let me =this;
      let question_id = question.id
      swal.fire({
        title: 'Eliminar una pregunta',
        text: "Esta acción no se puede revertir, Está a punto de eliminar una pregunta",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarla!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/psicoanalisis/borrar/'+question_id)
          .then(function (response) {
            swal.fire(
              'Eliminada',
              'Pregunta fue eliminada',
              'success'
            )
            me.getQuestions();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
      let me =this;
      me.title= "Registrar nueva pregunta";
      me.update = 0;
      me.form.reset();
    }
  },
  created(){
    Fire.$on('searching',() => {
          let query = this.$parent.search;
          axios.get('/findquestion?q=' + query)
          .then((response) => {
              this.Questions = response.data
          })
          .catch(() => {
          })
      })
  },
  mounted() {
   this.getQuestions()
  }
}
</script>
