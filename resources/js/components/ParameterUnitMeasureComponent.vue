<template>
  <div class="container-elements mp-1 mp-1">
    <div class="row">
      <div class="col-md-8 text-center">
        <button type="button" class="btn btn-outline-info btn-lg " disabled>{{template.variable}}</button>
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
        <button v-if="showSaveButton" @click="saveTask()" class="btn btn-success"> Guardar</button>
      </div>
    </div>
  </div>
</template>

<script>
 export default {
  name: 'parameters-measure',
  props: {
    template: Object
	  
  },
  data(){
    return{
      form: new Form ({
        id:"",
		category:"",
		variable:"",
		measure:""
        
      }),
      showSaveButton:false,
	  currentUser:""
    }
  },
  methods:{
    showSave(){
      this.showSaveButton=true
    },
    saveTask(){
      this.showSaveButton=false
      this.updateTask()
    },
	 getCurrentUser(){
      let me =this;
      axios.get('/usuario')
      .then(response => {
        me.currentUser = response.data.id
      });
    },
    updateTask(){
      let me = this
      me.form.task_id= me.task.id
      //me.form.task= me.task.task
      //me.form.allocator= me.task.allocator
      me.form.project_id= me.task.project_id
	  me.form.user_id= me.currentUser
      //me.form.addedValue=me.addedValueArray
      //me.form.correlation=me.correlationArray
      me.form.put('/measures/actualizar')
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
    this.form.fill(this.template)
   // me.addedValueArray=me.task.addedValue
   // me.correlationArray=me.task.correlation
	//me.getCurrentUser()
  }
}
</script>
