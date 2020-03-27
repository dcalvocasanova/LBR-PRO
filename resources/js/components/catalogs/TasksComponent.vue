<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Catálogos de opciones para las tareas</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('ADDED-VALUED-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Valor Agregado
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('CORRELATION-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Correlación
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('RISK-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Riesgos de trabajo
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('RISK-CONDITION-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Riesgo de condiciones de trabajo
                  </i>
                </button>
              </div>
            </div>
            <br>
            <div class="row mb-2">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('ORGANIZATIONAL-SKILL-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Competencias organizacionales
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('SPECIFIC-SKILL-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Competencias específicas
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('TECNICAL-SKILL-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Competencias técnicas
                  </i>
                </button>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('INDICATOR-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Indicadores
                  </i>
                </button>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary"
                  @click="LoadCatalog('SIDE-EFECT-T')"
                  data-toggle="modal"
                  data-target="#addCatalogs">
                  <i class="fas fa-swatchbook">
                    Catálogo: Posibles efectos
                  </i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-footer">
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
          }
      },
      methods:{
          LoadCatalog(code) {
            this.type = code;
      			if (code === "ADDED-VALUED-T"){this.catalog="Valor agregado"}
            if (code === "CORRELATION-T"){this.catalog="Correlación"}
            if (code === "RISK-T"){this.catalog="Área de riesgo de trabajo"}
            if (code === "RISK-CONDITION-T"){this.catalog="Riesgo de condiciones de trabajo"}
      			if (code === "ORGANIZATIONAL-SKILL-T"){this.catalog="Competencias organizacionales"}
      			if (code === "SPECIFIC-SKILL-T"){this.catalog="Competencias específicas"}
      			if (code === "TECNICAL-SKILL-T"){this.catalog="Competencias técnicas"}
            if (code === "INDICATOR-T"){this.catalog="Indicador"}
            if (code === "SIDE-EFECT-T"){this.catalog="Posibles efectos"}
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
                  me.LoadCatalog(this.type);
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
                 this.LoadCatalog(this.type);
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
              me.LoadCatalog(this.type);
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
