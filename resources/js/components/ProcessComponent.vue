<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de Procesos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Ficha </th>
                      <th> Entradas </th>
                      <th> Provedores </th>
					  <th> Actividades sustantivas </th>
					  <th> Responsable </th>
					  <th> Subproceso o producto </th>
					  <th> Resultado o producto </th>
					  <th> Usuarios  </th>
					  <th> Riesgos Asociados </th>
					  <th> PHVA </th>
					  <th> Subclasificacion </th>
					  <th> Indicadores </th>
					  <th> Acciones </th>

                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="proceso in Procesos.data" :key="proceso.id">

						<td v-text="proceso.file"></td>
                        <td v-text="proceso.input"></td>
						<td v-text="proceso.provider"></td>
						<td v-text="proceso.activity"></td>
						 <td v-text="proceso.responsible"></td>
						 <td v-text="proceso.subprocessProduct"></td>
						  <td v-text="proceso.resultProduct"></td>
						  <td v-text="proceso.user"></td>
						  <td v-text="proceso.risk"></td>
						  <td v-text="proceso.phva"></td>
						  <td v-text="proceso.subclassification"></td>
						  <td v-text="proceso.indicator"></td>
                        <td>
                          <button class="btn btn-info" @click="loadFieldsUpdate(proceso)"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger" @click="deleteUser(proceso)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Procesos" @pagination-change-page="getProcesos"></pagination>
            </div>
          </div>
        <!--
          <div class="col-6" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo parámetro">
            <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#loadProcesos">
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
                    <label class="bmd-label-floating">Ficha</label>
                    <select v-model="form.file" class=" form-control":class=" { 'is-invalid': form.errors.has('file') }">
                      <option v-for="file in Macroprocessfile">{{ file.relatedToLevel }}-{{ file.macroprocess }}-{{ file.process }}</option>
                    </select>
                    <has-error :form="form" field="file"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Entradas</label>
					<multiselect
                 		 v-model="Entradas"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="Inputs"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagInput" >
                	</multiselect>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Provedores</label>
                    <multiselect
                 		 v-model="Proveedores"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="Providers"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagProvider" >
                	</multiselect>
                  </div>
                </div>
              </div>

			  <div class="row">

				  <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Actividades sustantivas</label>
                    <multiselect
                 		 v-model="Actividades"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="Activities"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagActivity" >
                	</multiselect>
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
                    <label class="bmd-label-floating">Subproceso o producto</label>
                    <select v-model="form.subprocessProduct" class=" form-control":class="{ 'is-invalid': form.errors.has('subprocessProduct') }">
                      <option v-for="subprocess in SubprocessProduct">{{ subprocess.name }}</option>
                    </select>
                    <has-error :form="form" field="subprocessProduct"></has-error>
                  </div>
                </div>
			  </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Resultado o producto</label>
                    <input type="text" v-model="form.resultProduct"  class="form-control":class="{ 'is-invalid': form.errors.has('resultProduct') }">
                    <has-error :form="form" field="resultProduct"></has-error>
                  </div>
                </div>


				<div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Usuarios</label>
                    <multiselect
                 		 v-model="Usuarios"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="Users"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagUser" >
                	</multiselect>
                  </div>
                </div>


				  <div class="col-md-4">
				 <div class="form-group">
                    <label class="bmd-label-floating">Subclasificación</label>
                    <input type="text" v-model="form.subclassification"  class="form-control":class="{ 'is-invalid': form.errors.has('subclassification') }">
                    <has-error :form="form" field="subclassification"></has-error>
                  </div>
                </div>
              </div>
<hr/>
              <div class="row">
			    <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">PHVA</label>
                    <multiselect
                 		 v-model="PHVAs"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="PHVA"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagPHVA" >
                	</multiselect>
                  </div>
                </div>
				 <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Riesgos Asociados</label>
                    <multiselect
                 		 v-model="Riesgos"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="Risks"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagRisk" >
                	</multiselect>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Indicadores</label>
                   <multiselect
                 		 v-model="Indicadores"
                 		 placeholder="Seleccione o escriba una opción"
						  :options="Indicators"
						  :multiple="true"
						  :taggable="true"
						  :show-labels="false"
						  @tag="addTagIndicator" >
                	</multiselect>
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
      <div class="modal fade" id="loadProcesos" tabindex="-1" role="dialog" aria-labelledby="loadProcesosModalLabel-lg" aria-hidden="true">
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
                      <h4 class="card-title">Cargar Procesos usando un archivo excel</h4>
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
                          <button @click="getProcesos" data-dismiss="modal" class="btn btn-success">Regresar</button>
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
  props: {
     showDeleteAndUpdateButton: Number,
  },
  data(){
    return{
          form: new Form ({
            id:"",//Macroprocesfile ID
			relatedToLevel:"",
            project_id:"",//este valor debe ser el current project
			file:"",
            input:"",
            provider:"",
			activity:"",
			responsible:"",
            subprocessProduct:"",
			resultProduct:"",
			user:"",
			risk:"",
			phva:"",
			subclassification:"",
			indicator:""

          }),
		  project_id:"",//este valor debe ser el current project
          title:"Agregar nueva Ficha", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
	      processFile:"",
          Procesos:{}, //BD content
		  Macroprocessfile:{}, //BD content
		  SubprocessProduct:[{name:'subproceso'},{name:'producto'}],
          Inputs:[],
          Providers:[],
          Risks:[],
		  Indicators:[],
		  PHVA:[],
		  Activities:[],
		  Users:[],
		  //arreglos temporales
		  Entradas:[],
          Proveedores:[],
          Riesgos:[],
		  Indicadores:[],
		  PHVAs:[],
		  Actividades: [],
		  Usuarios:[]

      }
  },
  methods:{
	 getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.project_id = response.data.id
       me.form.project_id = response.data.id
	    this.getProcesos();
		this.getMacroprocessFile();
      });
    },
		loadfile(event){
			var files = event.target.files || event.dataTransfer.files;
			this.processFile = event.target.files[0];
			alert(files[0]);
			axios.post('/procesos/loadprocess',{process:this.processFile})
				.then(function(response){console.log(response)})
				.catch(function(response){console.log(response)})
			;
		},
	  addTagInput (newTag) {
      const tag = newTag

      this.Entradas.push(tag)
    },
	addTagProvider (newTag) {
      const tag = newTag

      this.Proveedores.push(tag)
    },
	addTagRisk (newTag) {
      const tag = newTag

      this.Riesgos.push(tag)
    },
	addTagPHVA (newTag) {
      const tag = newTag

      this.PHVAs.push(tag)
    },
	addTagIndicator (newTag) {
      const tag = newTag

      this.Indicadores.push(tag)
    },
	addTagActivity (newTag) {
      const tag = newTag

      this.Actividades.push(tag)
    },
	addTagUser (newTag) {
      const tag = newTag

      this.Usuarios.push(tag)
    },
		EventSubir(f){
          let me =this;
          me.processFile = f.target.files[0];
          console.log(me.processFile);
          var data = new FormData();
          data.append('archivo', me.processFile);
          axios.post('/Procesos/loadprocess', data, {
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
    getProcesos(page = 1) {
      let me =this;
      me.clearFields();
      axios.get('/procesos?page=' + page)
      .then(response => {
            me.Procesos = response.data; //get all projects from page
      });
    },
    getTemplate() {
      let me =this;
      axios.get('/procesos-plantilla')
      .then(response => {
        let blob = new Blob([response.data],{ type:'application/vnd.ms-excel'});
        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = "processs";
        link.click();
      });
    },

	getMacroprocessFile(){
		 let me =this;
          let url = '/macroprocesos/file?id='+me.project_id;
          axios.get(url).then(function (response) {
			 me.Macroprocessfile = response.data;
          })
          .catch(function (error) {
              console.log(error);
          });
	},
    saveMacroproceso(){
      let me =this;
	  let myResult = [];
	  myResult = me.form.file.split("-");
	  me.form.relatedToLevel = myResult[0];
	  me.form.file = myResult[1];
	  me.form.input = JSON.stringify(me.Entradas)

	  me.form.provider = JSON.stringify(me.Proveedores)
	  me.form.risk = JSON.stringify(me.Riesgos)
	  me.form.phva = JSON.stringify(me.PHVAs)
	  me.form.indicator = JSON.stringify(me.Indicadores)
      me.form.user = JSON.stringify(me.Entradas)
	  me.form.activity = JSON.stringify(me.Entradas)
      this.form.post('/procesos/guardar')
      .then(function (response) {
          me.clearFields();
          me.getProcesos();// show all processs
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
        me.form.put('/procesos/actualizar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Proceso actualizado con éxito'
           });
           me.getProcesos();
           me.clearFields();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    loadFieldsUpdate(process){
      let me =this;
      this.form.fill(process);
      me.update = process.id
      me.title="Actualizar información de la Ficha";
    },
    deleteMacroproceso(process){
      let me =this;
      let process_id = process.id
      swal.fire({
        title: 'Eliminar un proceso',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un proceso",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/procesos/borrar/'+process_id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'Proceso fue eliminado',
              'success'
            )
            me.getProcesos();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
      let me =this;
      me.title= "Registrar nuevo proceso";
      me.update = 0;
      me.form.reset();
    },
    LoadCatalogInput() {
      axios.get('catalogo?id=INPUT')
      .then(response => {
            //this.Inputs = response.data; //get all catalogs from category selected
		    let inputs = response.data;
		    for (let i =0; i<inputs.length;i++){

				 this.Inputs.push(inputs[i].name);
			}
      });
    },
    LoadCatalogProvider() {
      axios.get('catalogo?id=PROVIDER')
      .then(response => {
            let inputs = response.data;
		    for (let i =0; i<inputs.length;i++){

				 this.Providers.push(inputs[i].name);
			}
      });
    },
    LoadCatalogRisk() {
      axios.get('catalogo?id=RISK')
      .then(response => {
            let inputs = response.data;
		    for (let i =0; i<inputs.length;i++){

				 this.Risks.push(inputs[i].name);
			}
      });
    },
	LoadCatalogIndicator() {
      axios.get('catalogo?id=INDICATOR')
      .then(response => {
            let inputs = response.data;
		    for (let i =0; i<inputs.length;i++){

				 this.Indicators.push(inputs[i].name);
			}
      });
    },
	LoadCatalogPHVA() {
      axios.get('catalogo?id=PHVA')
      .then(response => {
            let inputs = response.data;
		    for (let i =0; i<inputs.length;i++){

				 this.PHVA.push(inputs[i].name);
			}
      });
    },
  },
  created(){
    Fire.$on('searching',() => {
          let query = this.$parent.search;
          axios.get('/findprocess?q=' + query)
          .then((response) => {
              this.Procesos = response.data
          })
          .catch(() => {
          })
      })
  },
  mounted() {
	  this.getCurrentProject();
      
       this.LoadCatalogInput();
       this.LoadCatalogProvider();
       this.LoadCatalogRisk();
	   this.LoadCatalogPHVA();
	   this.LoadCatalogIndicator();
	   
  }
}
</script>
