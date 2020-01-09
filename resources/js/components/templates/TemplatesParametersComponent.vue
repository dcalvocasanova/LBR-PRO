<template>
  <div class="container container-project">
    <div class="row" v-if="this.startUpCategorySelection === true">
      <div class="col-md-6">
        <div class="text-center" @click="loadCategory(0)">
          <img src="/img/site/workload.png" style="height:30%;width:50%;"class="avatar img-circle img-thumbnail" alt="avatar">
          <br>
          <label class="bmd-label-floating">Generar estudio de cargas de trabajo</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="text-center" @click="loadCategory(1)">
          <img src="/img/site/psychosocial.png" style="height:30%;width:50%;" class="avatar img-circle img-thumbnail" alt="avatar">
          <br>
          <label class="bmd-label-floating">Generar análisis psicosocial</label>
        </div>
      </div>
    </div>
    <div class="row" v-if="this.startUpCategorySelection === false">
      <div class="col-md-7 options-parameters">
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
      <div class="col-md-7 options-sub-parameters">
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
      <div class="col-md-7 options-categories">
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
      <div class="col-md-5 options-selected">
        <div class="card card-plain" v-if="this.showStencil === true" v-bind:key="updateList">
          <div class="card-header card-header-primary">
            <div class="col-12">
                <h3 class="card-title mt-0"> Instrumento de evaluación</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="title">
                  <tr>
                    <th style="width:20%"> Tipo </th>
                    <th style="width:70%"> Nombre </th>
                    <th style="width:10%"> Acción </th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="stencil in Stencils" :key="stencil.id">
                      <td v-text="stencil.identificator"></td>
                      <td v-text="stencil.name.substr(0,35)+'...'"></td>
                      <td>
                        <button class="btn-icon btn btn-danger"
                         @click="deleteStencil(stencil)">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">

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
                startUpCategorySelection:true,
                showTemplates:false,
                showParameters:false,
                showSubParameters:false,
                showItems:false,
                showStencil:false,
                parameter:{},
                category:{},
                typeOfStudy:0,
                updateList:0,
                item:{},
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
              if (param === 0){me.typeOfStudy=0;}
              else{me.typeOfStudy=1;}
              me.startUpCategorySelection = false;
              me.getMainParameters();
            },
            getMainParameters(page = 1) {
              let me =this;
              var url = '/parametros/cargatrabajo';
              if(me.typeOfStudy ==1){
                url='/parametros/psicosocial';
              }
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
              alert ("*NUEVO*"+item.id+":"+item.name);
              me.item = item;
              me.Stencils[item.id] = item; // add current item
              me.updateList += 1;
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
        }
    }
</script>
