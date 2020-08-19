<template>
  <div class="container-elements mp-1 mp-1">
    <div class="row">
      <div class="col-md-8 text-center">
        <button type="button" class="btn btn-outline-info btn-lg " disabled>Días de vacaciones</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.vacation"  class="form-control">
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-8 text-center">
        <button type="button" class="btn btn-outline-info btn-lg " disabled>Días de incapacidad</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.disability"  class="form-control">
        </div>
      </div>
    </div>
    <br>
    <div class="row mb-2">
      <div class="col-12 text-center">
        <button v-if="showSaveButton" @click="saveSettings()" class="btn btn-success"> Guardar</button>
      </div>
    </div>
  </div>
</template>
<script>
 import Treeselect from '@riophae/vue-treeselect'
 import '@riophae/vue-treeselect/dist/vue-treeselect.css'
 export default {
  components: { Treeselect},
  props: {
    
	  
  },
  data(){
    return{
      form: new Form ({
        id:"",
        project_id:"",
		vacation:0,
		disability:0
      }),
      showSaveButton:false,
	  projectID:""
    }
  },
  methods:{
    showSave(){
      this.showSaveButton=true
    },
    saveSettings(){
      this.showSaveButton=false
      this.updateSettings()
    },
    updateSettings(){
      let me = this
	  me.form.project_id = me.projectID
      me.form.put('/measures/ajustes')
      .then(function (response) {
         toast.fire({
          type: 'success',
          title: 'Elementos de la tarea agregados con éxito'
         });
      })
    },
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.projectID = response.data.id
      });
    },
  },
  created(){
    let me = this
    me.getCurrentProject()
  }
}
</script>
