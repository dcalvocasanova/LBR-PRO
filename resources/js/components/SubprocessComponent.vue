<template>
    <div class="container container-project">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de Subprocesos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>

					  <th> Proceso </th>
                      <th> Entradas </th>
                      <th> Provedores </th>
					  <th> Actividades sustantivas </th>
					  <th> Responsable </th>
					  <th> producto </th>
					  <th> Usuarios  </th>
					  <th> Riesgos Asociados </th>
					  <th> PHVA </th>
					  <th> Subclasificacion </th>
					  <th> Acciones </th>

                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="subproceso in Subprocesos.data" :key="subproceso.id">

						 <td v-text="subproceso.process"></td>
                        <td v-text="subproceso.input"></td>
						<td v-text="subproceso.provider"></td>
						<td v-text="subproceso.activity"></td>
						 <td v-text="subproceso.responsible"></td>
						  <td v-text="subproceso.product"></td>
						  <td v-text="subproceso.user"></td>
						  <td v-text="subproceso.risk"></td>
						  <td v-text="subproceso.phva"></td>
						  <td v-text="subproceso.subclassification"></td>
						  <td v-text="subproceso.indicator"></td>
                        <td>
                          <button class="btn btn-info" @click="loadFieldsUpdate(subproceso)"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger" @click="deleteUser(subproceso)"><i class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Subprocesos" @pagination-change-page="getSubprocesos"></pagination>
            </div>
          </div>
        <!--
          <div class="col-6" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo parámetro">
            <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#loadSubprocesos">
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
                    <label class="bmd-label-floating">Proceso</label>
                    <select v-model="form.process" class=" form-control":class=" { 'is-invalid': form.errors.has('sex') }">
                      <option v-for="process in Processfile">{{ process.relatedToLevel }}-{{ process.file }} - {{ process.subprocessProduct }}</option>
                    </select>
                    <has-error :form="form" field="process"></has-error>
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
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Responsable</label>
                    <input type="text" v-model="form.responsible"  class="form-control":class="{ 'is-invalid': form.errors.has('responsible') }">
                    <has-error :form="form" field="responsible"></has-error>
                  </div>
                </div>
				<div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Producto</label>
                    <input type="text" v-model="form.product"  class="form-control":class="{ 'is-invalid': form.errors.has('product') }">
                    <has-error :form="form" field="product"></has-error>
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
              </div>
<hr/>
              <div class="row">
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
                <button v-if="update == 0" @click="saveSubproceso()" class="btn btn-success">Añadir</button>
                <button v-if="update != 0" @click="updateMacrosubproceso()" class="btn btn-info">Actualizar</button>
                <button v-if="update != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="loadSubprocesos" tabindex="-1" role="dialog" aria-labelledby="loadSubprocesosModalLabel-lg" aria-hidden="true">
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
                      <h4 class="card-title">Cargar Subprocesos usando un archivo excel</h4>
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
                          <button @click="getSubprocesos" data-dismiss="modal" class="btn btn-success">Regresar</button>
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
            process:"",
            input:"",
            provider:"",
			activity:"",
			responsible:"",
			product:"",
			user:"",
			risk:"",
			phva:"",
			subclassification:"",
			indicator:"",
			project_id:2 //este valor debe ser el current project
          }),
          title:"Agregar nueva Ficha", //title to show
		 project_id:2, //este valor debe ser el current project
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
	      subprocessFile:"",
          Subprocesos:{}, //BD content
		  Processfile:{},
           Inputs:[],
          Providers:[],
          Risks:[],
		  Indicators:[],
		  PHVA:[], Activities:[],
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
		loadfile(event){
			var files = event.target.files || event.dataTransfer.files;
			this.subprocessFile = event.target.files[0];
			alert(files[0]);
			axios.post('/subprocesos/loadsubprocess',{subprocess:this.subprocessFile})
				.then(function(response){console.log(response)})
				.catch(function(response){console.log(response)})
			;
		},
		EventSubir(f){
          let me =this;
          me.subprocessFile = f.target.files[0];
          console.log(me.subprocessFile);
          var data = new FormData();
          data.append('archivo', me.subprocessFile);
          axios.post('/Subprocesos/loadsubprocess', data, {
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
    handleFileUpload(){
        this.file = this.$refs.file.files[0];
    },
    getSubprocesos(page = 1) {
      let me =this;
      me.clearFields();
      axios.get('/subprocesos?page=' + page)
      .then(response => {
            me.Subprocesos = response.data; //get all projects from page
      });
    },
    getTemplate() {
      let me =this;
      axios.get('/subprocesos-plantilla')
      .then(response => {
        let blob = new Blob([response.data],{ type:'application/vnd.ms-excel'});
        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = "subprocesss";
        link.click();
      });
    },
    getprocessFile(){
		 let me =this;
          let url = '/procesos/file?id='+me.project_id;
          axios.get(url).then(function (response) {
			 me.Processfile = response.data;
          })
          .catch(function (error) {
              console.log(error);
          });
	},
    saveSubproceso(){

      let me =this;
	   let myResult = [];
	  myResult = me.form.process.split("-");
	  me.form.relatedToLevel = myResult[0];
	  me.form.process = myResult[1];
	  me.form.input = JSON.stringify(me.Entradas)
	  me.form.provider = JSON.stringify(me.Proveedores)
	  me.form.risk = JSON.stringify(me.Riesgos)
	  me.form.phva = JSON.stringify(me.PHVAs)
	  me.form.indicator = JSON.stringify(me.Indicadores)
	  me.form.user = JSON.stringify(me.Usuarios)
	  me.form.activity = JSON.stringify(me.Actividades)
      this.form.post('/subprocesos/guardar')
      .then(function (response) {
          me.clearFields();
          me.getSubprocesos();// show all subprocesss
          toast.fire({
            type: 'success',
            title: 'Ficha registrada con éxito'
          });
      })
      .catch(function (error) {
          console.log(error);
      });

    },
    updateMacrosubproceso(){
        let me = this;
        //me.form.role="Usuario";
        me.form.put('/subprocesos/actualizar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Sub proceso actualizado con éxito'
           });
           me.getSubprocesos();
           me.clearFields();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    loadFieldsUpdate(subprocess){
      let me =this;
      this.form.fill(subprocess);
      me.update = subprocess.id
      me.title="Actualizar información de la Ficha";
    },
    deleteMacrosubproceso(subprocess){
      let me =this;
      let subprocess_id = subprocess.id
      swal.fire({
        title: 'Eliminar un subproceso',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un subproceso",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/subprocesos/borrar/'+subprocess_id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'Subproceso fue eliminado',
              'success'
            )
            me.getSubprocesos();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
      let me =this;
      me.title= "Registrar nuevo Subproceso";
      me.update = 0;
      me.form.reset();
    },
    LoadCatalogInput() {
      axios.get('catalogo?id=INPUT')
      .then(response => {
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
          axios.get('/findsubprocess?q=' + query)
          .then((response) => {
              this.Subprocesos = response.data
          })
          .catch(() => {
          })
      })
  },
  mounted() {
       this.getSubprocesos();
       this.LoadCatalogInput();
       this.LoadCatalogProvider();
       this.LoadCatalogRisk();
	   this.LoadCatalogPHVA();
	   this.LoadCatalogIndicator();
	   this.getprocessFile();
  }
}
</script>
