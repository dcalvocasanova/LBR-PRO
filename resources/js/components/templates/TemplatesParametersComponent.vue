<template>
  <div class="container container-project">
    <div class="row" >
      <div class="col-12">
        <div class="row col-12">
          <div class="col-md-6">
            <div class="col-12 show-templates">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <div class="row col-12">
                    <div class="col-10">
                      <h3 class="card-title mt-0"> Plantillas registradas </h3>
                    </div>
                    <div class="col-2" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva plantilla">
                      <button class="btn btn-primary" @click="CreateTemplate()">
                        <i class="fa fa-plus-circle"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="table">
                        <tr>
                          <th style="width:90px;"> Nombre </th>
                          <th style="width:20px;"> Acciones </th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr  v-for="template in Templates.data" :key="template.id">
                            <td v-text="template.name"></td>
                            <td>
                              <button class="btn-icon btn btn-info"
                                @click="showUpdateTemplate(template)">
                                  <i class="fas fa-edit"></i>
                              </button>
                              <button class="btn-icon btn btn-primary"
                              @click="duplicateTemplate(template)">
                                <i class="fa fa-clone"></i>
                              </button>
                              <button class="btn-icon btn btn-secondary"
                              @click="showTemplate(template)">
                                <i class="far fa-eye"></i>
                              </button>
                              <button class="btn-icon btn btn-danger"
                              @click="deleteTemplate(template)">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <pagination :data="Templates" @pagination-change-page="getTemplates"></pagination>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card addNewTemplates"  v-if="this.showCreateOrUpdate === true">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{title}}</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label class="bmd-label-floating">Nombre</label>
                        <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <label class="bmd-label-floating">Descripción</label>
                        <input v-model="form.description" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('description') }">
                        <has-error :form="form" field="description"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="container-buttons col-9">
                      <button v-if="updateTemplateValidator== 0" @click="saveTemplate()" class="btn btn-success">Añadir</button>
                      <button v-if="updateTemplateValidator!= 0" @click="updateTemplate()" class="btn btn-info">Actualizar</button>
                      <button v-if="updateTemplateValidator!= 0" @click="cancelar()" class="btn btn-secondary">Cancelar</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row col-12">
          <div class="col-md-6">
            <div class="col-12 options-parameters"  v-if="this.showCreateOrUpdate === true">
              <div class="card card-plain" v-if="this.showParameters === true">
                <div class="card-header card-header-primary">
                  <div class="col-md-12">
                      <h3 class="card-title mt-0"> Lista de parámetros</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <tr>
                          <th style="width:98%"> Nombre </th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="parameter in Parameters.data" :key="parameter.id">
                            <td v-text="parameter.name" @click="loadSubParameter(parameter)"></td>
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <pagination :data="Parameters" @pagination-change-page="getMainParameters"></pagination>
                </div>
              </div>
            </div>
            <div class="col-12 options-sub-parameters">
              <div class="card card-plain" v-if="this.showSubParameters === true">
                <div class="card-header card-header-primary">
                  <div class="row">
                    <div class="col-10 ">
                        <h3 class="card-title mt-0"> Lista de categorías de Parámetros</h3>
                    </div>
                    <div class="col-2">
                      <button class="btn btn-primary"
                      @click="goBackParameters()"
                      data-toggle="tooltip" data-placement="bottom" title="Regresar a la lista de parámetros">
                        <i class="fas fa-angle-double-left"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <tr>
                          <th style="width:98%"> Nombre </th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="subparameter in SubParameters.data" :key="subparameter.id">
                            <td v-text="subparameter.name" @click="loadItems(subparameter)"></td>
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <pagination :data="SubParameters" @pagination-change-page="getSubParameters"></pagination>
                </div>
              </div>
            </div>
            <div class="col-12 options-categories">
              <div class="card card-plain" v-if="this.showItems === true">
                <div class="card-header card-header-primary">
                  <div class="col-10">
                      <h3 class="card-title mt-0"> Lista de características a evaluar</h3>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-primary"
                    @click="goBackCategories()"
                    data-toggle="tooltip" data-placement="bottom" title="Regresar a las categorías de parámetros">
                      <i class="fas fa-angle-double-left"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <tr>
                          <th style="width:98%"> Nombre </th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="item in Items.data" :key="item.id">
                            <td v-text="item.name" @click="addStencil(item)"></td>
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <pagination :data="Items" @pagination-change-page="getItems"></pagination>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="options-selected">
              <div class="card card-plain" v-if="this.showStencil === true" v-bind:key="updateList">
                <div class="card-header card-header-primary">
                  <div class="col-12">
                      <h3 class="card-title mt-0"> Instrumento de evaluación</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">

                      <tbody>
                        <div v-if="this.showCreateOrUpdate === true">
                          <thead class="title">
                            <tr>
                              <th style="width:20%"> Tipo </th>
                              <th style="width:70%"> Nombre </th>
                              <th > Acción </th>
                            </tr>
                          </thead>
                          <tr v-for="stencil in Stencils":key="stencil.id">
                            <td v-text="stencil.identificator"></td>
                            <td v-text="stencil.name.substr(0,35)+'...'"  @click="showStencilDetails(stencil.name)"></td>
                            <td>
                              <button class="btn-icon btn btn-danger"
                               @click="deleteStencil(stencil)">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                            </td>
                          </tr>
                        </div>
                        <div v-else>
                          <thead class="title">
                            <tr>
                              <th style="width:30%"> Tipo </th>
                              <th style="width:70%"> Nombre </th>

                            </tr>
                          </thead>
                          <tr v-for="stencil in Stencils":key="stencil.id">
                            <td v-text="stencil.identificator"></td>
                            <td v-text="stencil.name.substr(0,35)+'...'" @click="showStencilDetails(stencil.name)"></td>
                          </tr>
                        </div>


                        </tbody>
                    </table>
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
        id:"",//template ID
        name:"",
        type:"",
        description:"",
        stencil:"",
      }),
      startUpCategorySelection:true,
      showTemplates:false,
      showParameters:false,
      showSubParameters:false,
      showItems:false,
      showStencil:false,
      showCreateOrUpdate:false,
      parameter:{},
      category:{},
      typeOfStudy:0,
      updateList:0,
      updateTemplateValidator:0,
      title:"",
      Templates:{}, //BD content
      Parameters:{},
      SubParameters:{},
      Items:{},
      Stencils:{}
    }
  },
  methods:{
    loadCategory(param){
      let me =this;
      me.getTemplates();
      me.getMainParameters();
    },
    getTemplates(page = 1){
      let me =this;
      var url = '/plantillas/buscarxtipo/workload';
      axios.get(url + '?page=' + page)
      .then(response => {
        me.Templates = response.data; //get all parameters in DB
        //me.showParameters = true; //Show parameters
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    CreateTemplate(){
      let me =this;
      me.updateTemplateValidator=0;
      me.title="Agregar nueva plantilla";
      me.showCreateOrUpdate = true;
    },
    showUpdateTemplate(template){
      let me =this;
      me.title = "Actualizar instrumento"
      me.showCreateOrUpdate=true;
      me.showParameters=true;
      me.updateTemplateValidator=1;
      me.Stencils = JSON.parse(template.stencil);
      me.form.fill(template);
      me.showStencil = true; //show items
      me.updateList += 1;
    },
    updateTemplate(){
      let me =this;
      if (Object.keys(me.Stencils).length !== 0) {
        me.form.stencil = JSON.stringify(me.Stencils);
        this.form.put('/plantillas/actualizar')
        .then(function (response) {
          me.cancelar();
          me.getTemplates();
          toast.fire({
            type: 'success',
            title: 'Instrumento actualizado con éxito'
          });
        })
        .catch(function (error) {
          console.log(error);
        });
      }else{
        swal.fire({
          title: 'Datos incompletos',
          text: "Es necesario agregar las variables a evaluar en el intrumento",
          type: 'warning',
          confirmButtonColor: '#114e7e',
          cancelButtonColor: '#20c9a6',
          confirmButtonText: '¡Entendido!'
        });
      }
    },
    deleteTemplate(template){
      let me =this;
      swal.fire({
        title: 'Eliminar una plantilla',
        text: "Esta acción no se puede revertir, Está a punto de eliminar una plantilla",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarla!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/plantillas/borrar/'+template.id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'La plantilla fue eliminada',
              'success'
            )
            me.getTemplates();
          })
          .catch(function (error) {
            console.log(error);
          });
        }
      })
    },
    duplicateTemplate(template){
      let me =this;
      me.form.fill(template);
      me.form.name+="*Copia";
      me.form.post('plantillas/guardar')
      .then(function (response) {
        toast.fire({
          type: 'success',
          title: 'Plantilla duplicada con éxito'
        });
        me.getTemplates();
        me.showCreateOrUpdate = false;
        me.showStencil=false;
        me.showItems=false;
        me.form.reset();
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    showTemplate(template){
      let me =this;
      me.showCreateOrUpdate=false;
      me.Stencils = JSON.parse(template.stencil);
      me.showStencil = true; //show items
      me.showItems=false;
      me.updateList += 1;
    },
    saveTemplate(){
      let me =this;
      me.form.type= me.parameter.type;
      if (Object.keys(me.Stencils).length !== 0) {
        me.form.stencil = JSON.stringify(me.Stencils);
        me.form.post('plantillas/guardar')
        .then(function (response) {
          toast.fire({
            type: 'success',
            title: 'Plantilla registrado con éxito'
          });
          me.getTemplates();
          me.showCreateOrUpdate = false;
          me.showStencil=false;
          me.showItems=false;
          me.form.reset();
        })
        .catch(function (error) {
          console.log(error);
        });
      }else{
        swal.fire({
          title: 'Datos incompletos',
          text: "Es necesario agregar las variables a evaluar en el intrumento",
          type: 'warning',
          confirmButtonColor: '#114e7e',
          cancelButtonColor: '#20c9a6',
          confirmButtonText: '¡Entendido!'
        });
      }
    },
    cancelar(){
      let me =this;
      me.showCreateOrUpdate = false;
      me.showStencil=false;
      me.showItems=false;
      me.form.reset();
    },
    getMainParameters(page = 1) {
      let me =this;
      var url = '/parametros/cargatrabajo';
      axios.get(url + '?page=' + page)
      .then(response => {
        me.Parameters = response.data; //get all parameters in DB
        me.showParameters = true; //Show parameters
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    loadSubParameter(parameter){
      let me =this;
      me.parameter = parameter; //Get id of the chosen paramater
      this.showSubParameters = true  // show list of subparameters
      this.showParameters = false; //stop showing parameters
      this.getSubParameters();
    },
    getSubParameters(page = 1){
      let me =this;
      axios.get('/subparametros/buscarxid/'+me.parameter.id+'?page='+ page)
      .then(function (response) {
        me.SubParameters = response.data; //get all subparamaters
      })
      .catch(function (error) {
        alert('error');
        console.log(error);
      });

    },
    loadItems(subparameter){
      let me =this;
      me.showItems = true; //Show items
      me.category =subparameter; //Get id of the chosen subparamater
      me.showSubParameters =false; //stop showing lis of SubParameters
      me.getItems();
    },
    getItems(page = 1){
      let me =this;
      axios.get('/variable/buscarxid/'+me.category.id+'?page='+ page)
      .then(function (response) {
        me.Items = response.data; //get all variables
      })
      .catch(function (error) {
        alert('error');
        console.log(error);
      });
    },
    addStencil(item){
      let me =this;
      me.showStencil = true; //show items
      //  me.item = item;
      me.Stencils[item.id] = item; // add current item
      me.Stencils[item.id].category = me.category.name;
      me.updateList += 1;
    },
    showStencilDetails(item){
      swal.fire(item);
    },
    deleteStencil(item){
      let me =this;
      delete me.Stencils[item.id];
      me.updateList += 1;
    },
    goBackCategories(){
      let me =this;
      me.showItems=false;
      me.showSubParameters=true;
    },
    goBackParameters(){
      let me =this;
      me.showSubParameters=false;
      me.showParameters=true;
    }
  },
  created() {
    this.getTemplates()
    this.getMainParameters()    
  }
}
</script>
