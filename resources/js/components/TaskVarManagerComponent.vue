<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <div class="col-md-8">
                <h3 class="card-title mt-0"> Lista de tareas</h3>
            </div>
            <div class="col-md-4" data-toggle="tooltip" data-placement="bottom" title="Agregar nueva variable">
              <button class="btn btn-primary"@click="detalle">
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="card-body card-body-fitted ">
            <div class="col-md-12">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Nombre </th>
                    <th> Tipo de Competencia </th>
                    <th> Riesgo por área </th>
                    <th> Factores de riesgo </th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="task in Tasks" :key="task.id">
                      <td v-text="task.name"></td>
                      <td>
                        <div class="btn-group" role="group">
                          <button id="btnGroupDropWorkTypeSPECIFIC" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Espefíca
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDropWorkTypeSPECIFIC">
                            <div v-for="wt in SpecificSkills":key="wt.id">
                              <a class="dropdown-item" href="#"  v-text="wt.name"></a>
                            </div>
                          </div>
                        </div>

                        <div class="btn-group" role="group">
                          <button id="btnGroupDropWorkTypeORGANIZACIONAL" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Organizacional
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDropWorkTypeORGANIZACIONAL">
                            <div v-for="wt in OrganizationalSkills":key="wt.id">
                              <a class="dropdown-item" href="#"  v-text="wt.name"></a>
                            </div>
                          </div>
                        </div>

                        <div class="btn-group" role="group">
                          <button id="btnGroupDropWorkTypeTECNICAL" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ténica
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDropWorkTypeTECNICAL">
                            <div v-for="wt in TecnicalSkills":key="wt.id">
                              <a class="dropdown-item" href="#"  v-text="wt.name"></a>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>

                        <select class="form-control">
                          <option v-for="p in Risk" :value="p.id">{{ p.name }}</option>
                        </select>

                      </td>
                      <td>
                        <select class="form-control">
                          <option v-for="p in RiskCondition" :value="p.id">{{ p.name }}</option>
                        </select>
                      </td>

                    </tr>
                  </tbody>
              </table>
            </div>
            <div class="col-md-6">

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
              form: new Form ({
                id:"",
                name:"",
                type:""
              }),
              showDetails: false,
              title:"Agregar nueva categoría de parámetro ", //title to show
              update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
              showVariable:0,
              AddedValue:{},
              Correlation:{},
              Risk:{},
              RiskCondition:{},
              OrganizationalSkills:{},
              SpecificSkills:{},
              TecnicalSkills:{},
              Tasks:[
                {
                  id:1,
                  name: "tarea 1",
                  inventory: 5,
                },
                {
                  id:2,
                  name: "tarea 2",
                  inventory: 10,
                },
                {
                  id:3,
                  name: "tarea 3",
                  inventory: 2,
                }
              ]
          }
      },
      methods:{
        detalle(){
          swal.fire(
            'Por el momento no tenemos Macroprocesos registrados',
            '¡Muy pronto tendremos la funcionalidad implementada!',
            'warning'
          )
        },
        LoadCatalogAddedValued() {
          axios.get('catalogo?id=ADDED-VALUED-T')
          .then(response => {
                this.AddedValue = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogCorrelation() {
          axios.get('catalogo?id=CORRELATION-T')
          .then(response => {
                this.Correlation = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogRisk() {
          axios.get('catalogo?id=RISK-T')
          .then(response => {
                this.Risk = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogRiskCondition() {
          axios.get('catalogo?id=RISK-CONDITION-T')
          .then(response => {
                this.RiskCondition = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogOrganizationalSkills() {
          axios.get('catalogo?id=ORGANIZATIONAL-SKILL-T')
          .then(response => {
                this.OrganizationalSkills = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogSpecificSkills() {
          axios.get('catalogo?id=SPECIFIC-SKILL-T')
          .then(response => {
                this.SpecificSkills = response.data; //get all catalogs from category selected
          });
        },
        LoadCatalogTecnicalSkills() {
          axios.get('catalogo?id=TECNICAL-SKILL-T')
          .then(response => {
                this.TecnicalSkills = response.data; //get all catalogs from category selected
          });
        }
      },
      mounted() {
        this.LoadCatalogAddedValued()
        this.LoadCatalogCorrelation()
        this.LoadCatalogRisk()
        this.LoadCatalogRiskCondition()
        this.LoadCatalogOrganizationalSkills()
        this.LoadCatalogSpecificSkills()
        this.LoadCatalogTecnicalSkills()
      }
}
</script>
