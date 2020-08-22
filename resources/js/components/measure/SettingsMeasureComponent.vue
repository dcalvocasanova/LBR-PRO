<template>
  <div class="container-elements mp-1 mp-1">
	<div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Inicio del proyecto</label>
                  <input type="date" v-model="form.startProject"
                    class="form-control":class="{ 'is-invalid': form.errors.has('startProject') }">
                  <has-error :form="form" field="startProject"></has-error>
                </div>
              </div>
		      <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Fin del proyecto</label>
                  <input type="date" v-model="form.endProject"
                    class="form-control":class="{ 'is-invalid': form.errors.has('endProject') }">
                  <has-error :form="form" field="endProject"></has-error>
                </div>
              </div>
	</div>
	<div class="row">
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block " disabled>Jornada</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.workdays"  class="form-control">
        </div>
      </div>
    </div>  
    <div class="row">
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Días de vacaciones</button>
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
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Días de incapacidad</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.disability"  class="form-control">
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Días laborados por semana</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.weekdays"  class="form-control">
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Días laborados por año</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.yeardays"  class="form-control">
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Capacitación al año</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en minutos</label>
          <input @click="showSave" type="number" v-model="form.training"  class="form-control">
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-4 text-center">
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Permisos temporles</button>
      </div>
      <br>
   <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo en horas</label>
          <input @click="showSave" type="number" v-model="form.license"  class="form-control">
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
		disability:0,
		workdays:0,
		weekdays:0,
		yeardays:0,
		training:0,
		license:0,
		startProject:"",
		endProject:""  
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
	getSettings(){
	  let me =this;
      axios.get('measures/getAjustes',{
        params:{
          id: me.projectID
        }
      })
      .then(response => {
		this.form.fill(response.data)
        //me.workday = response.data
      });
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
		getSettings()
      });
    },
  },
	 
  created(){
    let me = this
    me.getCurrentProject()
  }
}
</script>
