<template>
  <div class="container-elements mp-1 mp-1">
    <div class="row">
      <div class="col-md-8 text-center">
        <button type="button" class="btn btn-outline-info btn-lg " disabled>{{task.task}}</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.measure"  class="form-control">
        </div>
      </div>
    </div>
  
    
    <div class="row" v-if="showImproveOption">
      <div class="col-md-4" @click="showSave">
        <div class="form-group">
          <label class="bmd-label-floating"> </label>
          <treeselect
            :clearable="true"
            :searchable="true"
            :options="options"
            :limit="3"
            :max-height="200"
            placeholder="PHVA"
            noResultsText="No existe registro"
            clearValueText="Eliminar"
            v-model="form.PHVA"
            />
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
 import Treeselect from '@riophae/vue-treeselect'
 import '@riophae/vue-treeselect/dist/vue-treeselect.css'
 export default {
  name: 'tasks-measure',
  components: { Treeselect },
  props: {
    task: Object
	  
  },
  data(){
    return{
      form: new Form ({
        id:"",
       // task:"",
        //allocator:"",
        project_id:"",
		task_id:"",
		user_id:"",
        //procedure:"",
		measure:""
        //PHVA:"",
        //frecuency:"",
        //t_min:"",
        //t_avg:"",
        //t_max:"",
        //quantity:"",
        //laborType:"",
        //competence:"",
        //effort:"",
        //risk:"",
        //addedValue:[],
        //correlation:[]
		 
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
    this.form.fill(this.task)
   // me.addedValueArray=me.task.addedValue
   // me.correlationArray=me.task.correlation
	me.getCurrentUser()
  }
}
</script>
