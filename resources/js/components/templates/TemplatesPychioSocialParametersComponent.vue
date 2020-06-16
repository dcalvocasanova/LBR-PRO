<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="row">
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
                          @click="showUpdateTemplate(template)"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Editar preguntas de la plantilla">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn btn-primary"
                        @click="duplicateTemplate(template)"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Duplicar plantilla">
                          <i class="fa fa-clone"></i>
                        </button>
                        <button class="btn-icon btn btn-secondary"
                        @click="showTemplate(template)"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Ver preguntas de la plantilla">
                          <i class="far fa-eye"></i>
                        </button>
                        <button class="btn-icon btn btn-danger"
                        @click="deleteTemplate(template)">
                          <i class="fas fa-trash-alt"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Eliminar plantilla"></i>
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
                    <label class="bmd-label-floating">Criterio de evaluación</label>
                    <select v-model="form.description" class=" form-control">
                      <option v-for="c in Criterias" :key="c.id">{{ c.name }}</option>
                    </select>
                    <has-error :form="form" field="sex"></has-error>
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
    <br>
    <div class="row">
      <div class="col-md-6"  v-if="this.showCreateOrUpdate === true">
        <div class="row">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <div class="col-md-12">
                  <h3 class="card-title mt-0"> Lista de preguntas</h3>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th> Nombre </th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="question in Questions.data" :key="question.id">
                        <td v-text="question.question" @click="addStencil(question)"></td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <pagination :data="Questions" @pagination-change-page="getQuestions"></pagination>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="options-selected">
          <div class="card card-plain" v-if="this.showStencil === true" v-bind:key="updateList">
            <div class="card-header card-header-primary">
              <h3 class="card-title mt-0"> Instrumento de evaluación</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <tbody>
                    <div>
                      <thead class="title">
                        <tr>
                          <th > Nombre </th>
                          <th v-if="showCreateOrUpdate === true"> Acción </th>
                        </tr>
                      </thead>
                      <tr v-for="stencil in Stencils":key="stencil.id">
                        <td v-text="stencil.question.substr(0,20)+'...'" @click="showStencilDetails(stencil.question)"></td>
                        <td v-if="showCreateOrUpdate === true">
                          <button class="btn-icon btn btn-danger"
                           @click="deleteStencil(stencil)">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </td>
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
</template>

<script>
export default {
  data(){
    return{
      form: new Form ({
        id:"",
        name:"",
        type:"psychosocial",
        description:"",
        stencil:"",
      }),
      showParameters:false,
      showSubParameters:false,
      showItems:false,
      showStencil:false,
      showCreateOrUpdate:false,
      parameter:{},
      category:{},
      updateList:0,
      updateTemplateValidator:0,
      title:"",
      Templates:{},
      Questions:{},
      Criterias:{},

      Parameters:{},
      SubParameters:{},
      Items:{},
      Stencils:{}
    }
  },
  methods:{
    loadCategory(param){
      let me = this
      if (param === 0){me.typeOfStudy=0;}
      else{me.typeOfStudy=1;}
      me.startUpCategorySelection = false;
      me.getTemplates();
      me.getMainParameters();
    },
    getTemplates(page = 1){
      axios.get('/plantillas/buscarxtipo/psychosocial?page=' + page)
      .then(response => {
        this.Templates = response.data;
      });
    },
    getQuestions(page = 1){
      axios.get('/psicoanalisis/?page='+ page)
      .then(response => {
        this.Questions = response.data; //get all projects from page
      });
    },
    getCriterias() {
      axios.get('/criterios-evaluacion-all')
      .then(response => {
        this.Criterias = response.data; //get all projects from page
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
      me.form.type="psychosocial";
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
    addCriteriaToStencil(item){
      let me =this
      me.showStencil = true
      me.Stencils[item.id] = item
      me.updateList += 1
    },
    addStencil(item){
      let me =this
      me.showStencil = true
      me.Stencils[item.id] = item
      me.updateList += 1
    },
    showStencilDetails(item){
      swal.fire(item);
    },
    deleteStencil(item){
      let me =this;
      delete me.Stencils[item.id];
      me.updateList += 1;
    }
  },
  created() {
    this.getTemplates()
    this.getQuestions()
    this.getCriterias()
  }
}
</script>
