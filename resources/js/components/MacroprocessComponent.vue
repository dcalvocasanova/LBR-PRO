<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de Macroprocesos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Macroproceso </th>
                      <th> Entradas </th>		
                      <th> Provedores </th>
					  <th> Actividades sustantivas </th>
					  <th> Responsable </th>
					  <th> Proceso </th>
					  <th> Usiarios de los reultados </th>
					  <th> Riesgos Asociados </th>
					  <th> Indicadores </th>
					  <th style ="withd:120px"> Acciones </th>
                      
                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="macroproceso in Macroprocesos.data" :key="macroproceso.id">
                        <td v-text="macroproceso.macroprocess"></td>
                        <td v-text="macroproceso.input"></td>
						<td v-text="macroproceso.provider"></td>
						<td v-text="macroproceso.activity"></td>
						<td v-text="macroproceso.responsible"></td>
						<td v-text="macroproceso.process"></td>
						<td v-text="macroproceso.user"></td>
						<td v-text="macroproceso.risk"></td>
						<td v-text="macroproceso.indicator"></td>
                        <td>
                          <button class="btn btn-info" @click="loadFieldsUpdate(macroproceso)"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger" @click="deleteUser(macroproceso)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Macroprocesos" @pagination-change-page="getMacroprocesos"></pagination>
            </div>
          </div>
        <!--
          <div class="col-6" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo parámetro">
            <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#loadMacroprocesos">
              Cargar usuario usando un archivo
              <i class="fa fa-plus-circle"></i>
            </button>
          </div>
        -->
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ title }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating"> Macroproceso </label>
                    <select v-model="form.macroprocess" class=" form-control":class="{ 'is-invalid': form.errors.has('macroprocess') }">
                      <option v-for="macroprocess in Levels">{{ macroprocess }}</option>
                    </select>
                    <has-error :form="form" field="macroprocess"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Entradas</label>
                    <select v-model="form.input" class=" form-control":class=" { 'is-invalid': form.errors.has('input') }">
                      <option v-for="input in Inputs">{{ input.name }}</option>
                    </select>
                    <has-error :form="form" field="input"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Provedores</label>
                    <select v-model="form.provider" class=" form-control":class=" { 'is-invalid': form.errors.has('provider') }">
                      <option v-for="provider in Providers">{{ provider.name }}</option>
                    </select>
                    <has-error :form="form" field="provider"></has-error>
                  </div>
                </div>
              </div>
				
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Actividades Sustantivas</label>
                    <input type="text" v-model="form.activity"  class="form-control":class="{ 'is-invalid': form.errors.has('activity') }">
                    <has-error :form="form" field="activity"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Responsable</label>
                    <input type="text" v-model="form.responsible"  class="form-control":class="{ 'is-invalid': form.errors.has('responsible') }">
                    <has-error :form="form" field="responsible"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Proceso</label>
                    <input type="text" v-model="form.process"  class="form-control":class="{ 'is-invalid': form.errors.has('process') }">
                    <has-error :form="form" field="process"></has-error>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Usuarios</label>
                    <input type="text" v-model="form.user"  class="form-control":class="{ 'is-invalid': form.errors.has('user') }">
                    <has-error :form="form" field="user"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Riesgos Asociados</label>
                    <select v-model="form.risk" class=" form-control":class=" { 'is-invalid': form.errors.has('risk') }">
                      <option v-for="risk in Risks">{{ risk.name }}</option>
                    </select>
                    <has-error :form="form" field="risk"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Indicadores</label>
                    <select v-model="form.indicator" class=" form-control":class=" { 'is-invalid': form.errors.has('indicator') }">
                      <option v-for="indicator in Indicators">{{ indicator.name }}</option>
                    </select>
                    <has-error :form="form" field="indicator"></has-error>
                  </div>
                </div>
              </div>
              <div class="container-buttons">
                <button v-if="update == 0" @click="saveMacroproceso()" class="btn btn-success">Añadir</button>
                <button v-if="update != 0" @click="updateMacroproceso()" class="btn btn-info">Actualizar</button>
                <button v-if="update != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="loadMacroprocesos" tabindex="-1" role="dialog" aria-labelledby="loadMacroprocesosModalLabel-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="ParameterModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <button @click="getTemplate" class="btn btn-success">Generar archivo</button>
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title">Cargar Macroprocesos usando un archivo excel</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="bmd-label-floating">Cargar archivo</label>
                            <input  type="file" id ="procesar_archivo" @change="EventSubir">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <button @click="getMacroprocesos" data-dismiss="modal" class="btn btn-success">Regresar</button>
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
  props: {
     showDeleteAndUpdateButton: Number,
	 
     Node: Object,
	 Title: String,
	 Title1: Array
 
  },
  data(){
    return{
          form: new Form ({
            id:"",//Macroprocesfile ID
            macroprocess:"",
            input:"",
            provider:"",
			activity:"",
            responsible:"",
            process:"",
			user:"",
			risk:"",
			indicator:""
            
           
          }),
		  level: new Form({
          id:"", //level projectID
          levels:"",
          project_id:""
        }),
		  project_id:2,
		  //Levels:{}, //All registered projects
          title:"Agregar nueva Ficha", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
	      macroprocessFile:"",
          Macroprocesos:{}, //BD content
		  Levels: {},
		 //Macroprocesses:[{name:'macroproceso 1'},{name:'macroproceso 2'}],
		  Macroprocesses:[],
          Inputs:{},
          Providers:{},
          Risks:{},
		  Indicators:{}
		
      }
  },
  methods:{
		loadfile(event){
			var files = event.target.files || event.dataTransfer.files;
			this.macroprocessFile = event.target.files[0];
			alert(files[0]);
			axios.post('/macroprocesos/loadmacroprocess',{macroprocess:this.macroprocessFile})
				.then(function(response){console.log(response)})
				.catch(function(response){console.log(response)})
			;
		},
		EventSubir(f){
          let me =this;
          me.macroprocessFile = f.target.files[0];
          console.log(me.macroprocessFile);
          var data = new FormData();
          data.append('archivo', me.macroprocessFile);
          axios.post('/Macroprocesos/loadmacroprocess', data, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }
          )
          .then(response => {
            toast.fire({
              type: 'success',
              title: 'Se cargó el archivo'
            });
          })
          .catch(function (error) {
              console.log(error);
              alert("no funca");
          });
    },
    handleFileUpload(){
        this.file = this.$refs.file.files[0];
    },
    getMacroprocesos(page = 1) {
      let me =this;
      me.clearFields();
      axios.get('/macroprocesos?page=' + page)
      .then(response => {
            me.Macroprocesos = response.data; //get all projects from page
      });
    },
    getTemplate() {
      let me =this;
      axios.get('/macroprocesos-plantilla')
      .then(response => {
        let blob = new Blob([response.data],{ type:'application/vnd.ms-excel'});
        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = "macroprocesss";
        link.click();
      });
    },
    
    saveMacroproceso(){
      let me =this;
      this.form.post('/macroprocesos/guardar')
      .then(function (response) {
          me.clearFields();
          me.getMacroprocesos();// show all macroprocesss
          toast.fire({
            type: 'success',
            title: 'Ficha registrada con éxito'
          });
      })
      .catch(function (error) {
          console.log(error);
      });

    },
    updateMacroproceso(){
        let me = this;
        //me.form.role="Usuario";
        me.form.put('/macroprocesos/actualizar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Usuario actualizado con éxito'
           });
           me.getMacroprocesos();
           me.clearFields();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    loadFieldsUpdate(macroprocess){
      let me =this;
      this.form.fill(macroprocess);
      me.update = macroprocess.id
      me.title="Actualizar información de la Ficha";
    },
    deleteMacroproceso(macroprocess){
      let me =this;
      let macroprocess_id = macroprocess.id
      swal.fire({
        title: 'Eliminar un usuario',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un usuario",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/macroprocesos/borrar/'+macroprocess_id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'Usuario fue eliminado',
              'success'
            )
            me.getMacroprocesos();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
      let me =this;
      me.title= "Registrar nueva Ficha Macroproceso";
      me.update = 0;
      me.form.reset();
    },
    LoadCatalogInput() {
      axios.get('catalogo?id=INPUT')
      .then(response => {
            this.Inputs = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogProvider() {
      axios.get('catalogo?id=PROVIDER')
      .then(response => {
            this.Providers = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogRisk() {
      axios.get('catalogo?id=RISK')
      .then(response => {
            this.Risks = response.data; //get all catalogs from category selected
      });
    },
	LoadCatalogIndicator() {
      axios.get('catalogo?id=INDICATOR')
      .then(response => {
            this.Indicators = response.data; //get all catalogs from category selected
      });
    },
	getLevels(){
          let me =this;
          let url = '/estructura/macroprocesos?id='+me.project_id;
          axios.get(url).then(function (response) {
			 me.Levels = response.data;
          })
          .catch(function (error) {
              console.log(error);
          });
		
	},
  },
  created(){
    Fire.$on('searching',() => {
          let query = this.$parent.search;
          axios.get('/findmacroprocess?q=' + query)
          .then((response) => {
              this.Macroprocesos = response.data
          })
          .catch(() => {
          })
      })
	 
  },
  mounted() {
	  this.getLevels();
       this.getMacroprocesos();
       this.LoadCatalogInput();
       this.LoadCatalogProvider();
       this.LoadCatalogRisk();
	   this.LoadCatalogIndicator();
	   
	  
	   
	   
  }
}
</script>
