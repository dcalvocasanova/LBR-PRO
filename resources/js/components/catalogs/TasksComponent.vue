<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Catálogos de opciones para las tareas</h4>
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadSubCategoryCatalog('P')"
                  data-toggle="modal"
                  data-target="#PHVACatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: PHVA
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadCatalog('FRECUENCY')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Frecuencias
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadCatalog('EFFORT-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Esfuerzo
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadDoubleCatalog('WORKTYPE')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Tipo de trabajo
                  </i>
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadCatalog('ADDED-VALUED-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Valor Agregado
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadCatalog('CORRELATION-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Correlación
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadDoubleCatalog('SKILL-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Competencias de trabajo
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="loadDoubleCatalog('RISK-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Riesgos de trabajo
                  </i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addCatalogs" tabindex="-1" role="dialog" aria-labelledby="categoriesModalLabel-lg" aria-hidden="true">
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
                              <button v-if="hasSubCategories"
                                class="btn btn-primary" @click="addSubCategory(cat)" data-toggle="modal"
                                data-target="#addSubCatalogs"><i class="fa fa-plus"></i>
                              </button>
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
    <div class="modal fade" id="addSubCatalogs" tabindex="-2" role="dialog" aria-labelledby="subCategoriesModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="exampleModalLabel">Gestión del catálogo de {{catalog}} {{subCatalog}}</h5>
            <button type="button" @click="exitSubCatalog()" class="close" data-dismiss="modal" aria-label="Close">
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
                          <tr  v-for="cat in SubCatalog" :key="cat.id">
                            <td v-text="cat.name"></td>
                            <td>
                              <button class="btn btn-info" @click="loadCatalogoUpdate(cat)"><i class="fas fa-edit"></i></button>
                              <button v-if="hasExtraSubCategories"
                                class="btn btn-primary" @click="addExtraSubCategory(cat)" data-toggle="modal"
                                data-target="#addExtraSubCatalogs"><i class="fa fa-plus"></i>
                              </button>
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
    <div class="modal fade" id="addExtraSubCatalogs" tabindex="-3" role="dialog" aria-labelledby="subCategoriesModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="exampleModalLabel"> {{catalog}} {{subCatalog}} {{extraSubCatalog}}</h5>
            <button type="button" @click="exitExtraSubCatalog()" class="close" data-dismiss="modal" aria-label="Close">
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
                          <tr  v-for="cat in SubCatalog" :key="cat.id">
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
        id:"",
        type:"",
        name:""
      }),
      catalog:"",
      subCatalog:"",
      extraSubCatalog:"",
      catalog_id:"",
      subCatalog_id:"",
      title:"Registrar nuevo elemento",
      type:"INPUT",
      subCatalog: 0,
      hasSubCategories: false,
      hasExtraSubCategories: false,
      updateCatalogo:0,
      status: 'C',
      Catalog:{},
      SubCatalog:{},
    }
  },
  methods:{
    loadCatalog(code) {
      this.type = code
      this.status = 'C'
      this.hasSubCategories = false
      this.hasExtraSubCategories = false
      if (code === "FRECUENCY"){this.catalog="Frecuencias"}
      if (code === "ADDED-VALUED-T"){this.catalog="Valor agregado"}
      if (code === "CORRELATION-T"){this.catalog="Correlación"}
      if (code === "EFFORT-T"){this.catalog="Esfuerzo de trabajo"}
      if (code === "WORKTYPE"){this.catalog="Tipo de trabajo"}
      if (code === "SKILL-T"){
        this.hasSubCategories = true
      }
      if (code === "RISK-T"){
        this.hasSubCategories = true
        this.hasExtraSubCategories = true
      }
      axios.get('catalogo?id=' + code)
      .then(response => {
        this.Catalog = response.data;
      });
    },
    loadDoubleCatalog(code){
      this.type = code
      this.status = 'C'
      this.hasSubCategories = true
      if (code === "RISK-T"){
        this.catalog="Riesgo de trabajo"
        this.catalog_id="RISK-T"
        this.hasExtraSubCategories = true
      }
      if (code === "SKILL-T"){
        this.catalog="Competencias de trabajo"
        this.catalog_id="SKILL-T"
        this.hasExtraSubCategories = false
      }
      axios.get('catalogo?id=' + code)
      .then(response => {
        this.Catalog = response.data;
      });
    },
    addSubCategory(category){
      let code = category.id +'-T'
      this.subCatalog_id = code
      this.subCatalog= " : "+category.name
      this.type= code
      this.loadSubCategoryCatalog(code)
    },
    addExtraSubCategory(category){
      let code = category.id +'-T'
      this.extraSubCatalog= " | "+category.name
      this.type= code
      this.loadSubCategoryCatalog(code)
    },
    loadSubCategoryCatalog(code){
      this.type = code
      this.status = 'S'
      axios.get('catalogo?id=' + code)
      .then(response => {
        this.SubCatalog = response.data;
      });
    },
    saveCatalog(){
      let me =this
      this.form.type = this.type;
      this.form.post('/catalogo/guardar')
      .then(function (response) {
        me.clearFields()
        toast.fire({
          type: 'success',
          title: 'Catálogo agregado con éxito'
        });
      })
    },
    updateCatalog(){
      this.form.put('/catalogo/actualizar')
      .then(function (response) {
        toast.fire({
          type: 'success',
          title: 'Elemento actualizado con éxito'
        });
      })
      this.clearFields();
    },
    loadCatalogoUpdate(catalog){
      this.title= "Actualizar elemento";
      this.form.type = catalog.type;
      this.form.fill(catalog)
      this.updateCatalogo= catalog.id;
    },
    clearFields(){
      let me =this
      me.cleanForm()
      me.updateUI()
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
          })
          this.updateUI()
        }
      })
    },
    updateUI(){
      let me = this
      if(me.status === 'C'){
        me.loadCatalog(me.type)
      }
      else{
        me.loadSubCategoryCatalog(me.type)
      }
    },
    exitSubCatalog(){
      let me =this
      me.cleanForm()
      me.type = me.catalog_id
    },
    exitExtraSubCatalog(){
      let me =this
      me.cleanForm()
      me.type = me.subCatalog_id
    },
    cleanForm(){
      let me =this
      me.title= "Registrar nuevo elemento";
      me.updateCatalogo= 0;
      me.form.reset();
    }
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
