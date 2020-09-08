<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Catálogos de opciones del Macro procesos</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('INPUT')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Entradas
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('PROVIDER')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Proveedores
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('INDICATOR')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Indicadores
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('RISK')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Riesgos
                  </i>
                </button>                
              </div>
            </div>
            <br>
            <div class="row mb-2">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('RISK-FRECUENCY')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Frecuencia del riesgo
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('RISK-CONSECUENCE')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Consecuencia del riesgo
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('RISK-MATURITY')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Nivel de madurez en relación con el riesgo
                  </i>
                </button>
              </div>
            </div>
            <div class="row mb-2">

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addCatalogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="exampleModalLabel">Gestión del catálogo de {{catalog}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-plain">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title mt-0">Lista de elementos</h4>
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
                          <tr  v-for="cat in Catalog" :key="cat.id">
                            <td v-text="cat.name"></td>
                            <td>
                              <button class="btn btn-info" @click="loadCatalogoUpdate(cat)"><i class="fas fa-edit"></i></button>
                              <button class="btn btn-danger" @click="deleteCatalog(cat)"><i class="fas fa-trash-alt"></i></button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ title }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                          <has-error :form="form" field="nombre"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="container-buttons">
                          <button v-if="updateCatalogo == 0" @click="saveCatalog()" class="btn btn-success">Añadir</button>
                          <button v-if="updateCatalogo != 0" @click="updateCatalog()" class="btn btn-info">Actualizar</button>
                          <button v-if="updateCatalogo != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
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
    <div class="modal fade" id="PHVACatalogs" tabindex="-4" role="dialog" aria-labelledby="PHVModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="exampleModalLabel">Gestión del catálogo PHVA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-plain">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title mt-0">Lista de elementos</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                          <a @click="loadSubCategoryCatalog('P')" class="nav-link active" id="pills-p-tab" data-toggle="pill" href="#pills-catalogs" role="tab" aria-controls="pills-catalogs" aria-selected="true">Planear</a>
                        </li>
                        <li class="nav-item">
                          <a @click="loadSubCategoryCatalog('H')" class="nav-link" id="pills-h-tab" data-toggle="pill" href="#pills-catalogs" role="tab" aria-controls="pills-catalogs" aria-selected="false">Hacer</a>
                        </li>
                        <li class="nav-item">
                          <a @click="loadSubCategoryCatalog('V')" class="nav-link" id="pills-v-tab" data-toggle="pill" href="#pills-catalogs" role="tab" aria-controls="pills-catalogs" aria-selected="false">Verificar</a>
                        </li>
                        <li class="nav-item">
                          <a @click="loadSubCategoryCatalog('A')" class="nav-link" id="pills-a-tab" data-toggle="pill" href="#pills-catalogs" role="tab" aria-controls="pills-catalogs" aria-selected="false">Actuar</a>
                        </li>
                      </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-catalogs" role="tabpanel" aria-labelledby="pills-catalogs-tab">
                          <table class="table" :key ="subCatalog">
                            <tbody>
                                <tr v-for="s in SubCatalog" :key="s.id" >
                                  <td>
                                    <span v-text="s.name"></span>
                                  </td>
                                  <td>
                                    <button class="btn btn-info" @click="loadCatalogoUpdate(s)"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" @click="deleteCatalog(s)"><i class="fas fa-trash-alt"></i></button>
                                  </td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ title }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="bmd-label-floating">Nombre</label>
                          <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                          <has-error :form="form" field="nombre"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="container-buttons">
                        <button v-if="updateCatalogo == 0" @click="saveCatalog()" class="btn btn-success">Añadir</button>
                        <button v-if="updateCatalogo != 0" @click="updateCatalog()" class="btn btn-info">Actualizar</button>
                        <button v-if="updateCatalogo != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
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
  data(){
    return{
      form: new Form ({
        id:"",//User ID
        type:"",
        name:""
      }),
      catalog:"",
      title:"Registrar nuevo elemento", //title to show
      type:"INPUT", //indicates which catalog is shown
      updateCatalogo:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
      Catalog:{}, //BD content
      SubCatalog:{},
      showEvents: false
    }
  },
  methods:{
    loadSubCategoryCatalog(code){
      this.type = code
      axios.get('catalogo?id=' + code)
      .then(response => {
        this.SubCatalog = response.data;
      });
    },
    LoadCatalog(code) {
      this.type = code
      this.showEvents = false
      if (code === "INPUT"){this.catalog="Entradas"}
      if (code === "PROVIDER"){this.catalog="Proveedores"}
      if (code === "RISK"){this.catalog="Riesgos"}
      if (code === "INDICATOR"){this.catalog="Indicadores"}
      if (code === "PHVA"){this.catalog="PHVA"}
      if (code === "RISK-FRECUENCY"){this.catalog="Frecuencia del riesgo"}
      if (code === "RISK-CONSECUENCE"){this.catalog="Consecuencia del riesgo"}
      if (code === "RISK-MATURITY"){this.catalog="Nivel de madurez en relación con el riesgo"}
      if (code === "RISK-LEVEL"){this.catalog="Niveles de riesgo"}
      axios.get('catalogo?id=' + code)
      .then(response => {
        this.Catalog = response.data; //get all catalogs from category selected
      });
    },
    saveCatalog(){
      let me =this;
      this.form.type = this.type;
      this.form.post('/catalogo/guardar')
      .then(function (response) {
        me.clearFields();
        toast.fire({
          type: 'success',
          title: 'Catálogo agregado con éxito'
        });
      })
      .catch(function (error) {
        console.log(error);
      });

    },
    updateCatalog(){
      this.form.type = this.type;
      this.form.put('/catalogo/actualizar')
      .then(function (response) {
        toast.fire({
          type: 'success',
          title: 'Elemento actualizado con éxito'
        });
      })
      .catch(function (error) {
        console.log(error);
      });
      this.clearFields();
    },
    loadCatalogoUpdate(catalog){
      this.title= "Actualizar elemento";
      this.form.fill(catalog)
      this.updateCatalogo= catalog.id;
    },
    clearFields(){
      let me =this;
      me.title= "Registrar nuevo elemento";
      me.updateCatalogo= 0;
      me.form.reset();
      me.LoadCatalog(me.type);
      me.LoadSubCatalog(me.type);
    },
    deleteCatalog(catalog){
      let me =this;
      let catalog_id = catalog.id
      swal.fire({
        title: 'Eliminar elemento',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un elemento del catálogo",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/catalogo/borrar/'+catalog_id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'El elemento fue eliminado',
              'success'
            )
            this.LoadCatalog(this.type);
          })

          .catch(function (error) {
            console.log(error);
          });
          this.LoadCatalog(this.type);
        }
      })
    },
  },
  created(){
    Fire.$on('searching',() => {
      toast.fire({
        type: 'WARNING',
        title: 'Las búsquedas se encuentran deshabilitadas en esta opción'
      });
    })
  }
}
</script>
