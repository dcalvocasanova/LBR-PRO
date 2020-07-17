<template>
  <div class="container-elements mp-1 mp-1">
	  <div class="card-body">

		<div class="row">
		  <div class="col-md-8 text-center">
			<button type="button" class="btn btn-outline-info btn-lg " disabled>{{category.variable}}</button>
		  </div>
		  <br>
		  <div class="col-md-4">
			<div class="form-group">
			  <label class="bmd-label-floating">Tiempo en minutos</label>
			  <input @click="showSave" type="number" v-model="form.measure"  class="form-control">
			</div>
		  </div>
		</div>
		<br>
		<div class="row mb-2">
		  <div class="col-12 text-center">
			<button v-if="showSaveButton" @click="saveCategory(category)" class="btn btn-success"> Guardar</button>
		  </div>
		</div>
	  </div>
  </div>
</template>
<script>
 export default {
  props: {
    category  
  },
  data(){
    return{
      form: new Form ({
        id:"",
        category_id:"",
        variable:"",
        measure:"",
        project_id:"",
        user_id:""
      }),
      showSaveButton:false,
      currentUser:"",
      currentProject:""
    }
  },
  methods:{
    showSave(){
      this.showSaveButton=true
    },
    saveCategory(category){
      this.showSaveButton=false
      this.updateMeasure(category)
    },
	getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.currentProject = response.data.id
        me.getCurrentUser()
       // me.LoadLevelsOfStructure()

      });
    },
	 getCurrentUser(){
      let me =this;
      axios.get('/usuario')
      .then(response => {
        me.currentUser = response.data.id
      });
    },
    updateMeasure(category){
      let me = this
      me.form.category_id= category.id
	  me.form.variable= category.variable
      me.form.project_id= me.currentProject
	  me.form.user_id= me.currentUser
      me.form.put('/parameters_measures/actualizar')
      .then(function (response) {
         toast.fire({
          type: 'success',
          title: 'Elementos de la tarea agregados con éxito'
         });
      })
    },
  },
  created(){
    let me = this
    //this.form.fill(this.template)
	me.getCurrentProject()
  }
}
</script>
