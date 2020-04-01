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
            <div class="col-md-6">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Nombre </th>
                    <th> Opciones </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="task in Tasks" :key="task.id">
                    <td v-text="task.name"></td>
                    <td>
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
          form: new Form ({
            id:"",
            name:"",
            type:""
          }),
          showDetails: false,
          title:"Agregar nueva categoría de parámetro ", //title to show
          update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
          showVariable:0,
          Frecuencies:{},
          WorkTypes:{},
          Tasks:[
            {
              id:1,
              name: "tarea 1",
              inventory: 5,
              unit_price: 45.99
            },
            {
              id:2,
              name: "tarea 2",
              inventory: 10,
              unit_price: 123.75
            },
            {
              id:3,
              name: "tarea 3",
              inventory: 2,
              unit_price: 399.50
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
    getResults(page = 1) {
      axios.get('/variables?page=' + page)
      .then(response => {
          this.Variables = response.data; //get all projects from page.
      });
    },
    showSubVariables(variable){
      let me =this;
      me.showVariable= variable.id;
      me.Variable =variable;
      axios.post('/variables/setsession',{
        id: parameter.id,
        name: parameter.name
      })
      .then(function (response) {
          me.componentVariableKey += 1;
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    showExtraValidations(){
      if(this.form.tipo =="number") {
          this.showDetails= true;
      }else{
          this.showDetails= false;
      }
    },
    getVaraibles(){
        let me =this;
        me.clearFields();
        axios.get('/variables')
        .then(function (response) {
            me.Variables = response.data; //get all parameters
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    saveVariable(){
        let me =this;
        this.form.post('/variables/guardar')
        .then(function (response) {
            me.salir();
            me.getVaraibles();// show all users
            toast.fire({
              type: 'success',
              title: 'Varaible registrada con éxito'
            });
        })
        .catch(function (error) {
            console.log(error);
        });

    },
    updateVariable(){
        let me = this;
        this.form.put('/variables/actualizar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Variable actualizada con éxito'
           });
           $('#addVariable').modal('toggle');
           me.getVaraibles();
           me.salir();
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    loadFieldsUpdate(variable){
      let me =this;
      me.update = variable.id
      me.title="Actualizar información de la variable";
      me.form.nombre = variable.name;
      me.form.identificador = variable.identificator;
      me.form.tipo = variable.type;
      me.form.valor=variable.value;
      me.form.medida=variable.measure;
      me.form.regla=variable.rule;
      me.form.id = variable.id;
      if (me.form.tipo =="number"){this.showDetails= true;}
    },
    deleteVariable(variable){
      let me =this;
      swal.fire({
        title: 'Eliminar una variable',
        text: "Esta acción no se puede revertir, Está a punto de eliminar una variable",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarla!'
      })
      .then((result) => {
        if (result.value) {
          axios.delete('/variables/borrar/'+variable.id)
          .then(function (response) {
            swal.fire(
              'Eliminado',
              'Variable fue eliminada',
              'success'
            )
            me.getVaraibles();
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      })
    },
    clearFields(){
        let me =this;
        me.title="Agregar nueva variable",
        me.update = 0;
        me.form.reset();
        me.showDetails= false;
    },
    LoadCatalogFrecuency() {
      axios.get('catalogo?id=FRECUENCY')
      .then(response => {
            this.Frecuencies = response.data; //get all catalogs from category selected
      });
    },
    LoadCatalogWorkType() {
      axios.get('catalogo?id=WORKTYPE')
      .then(response => {
            this.WorkTypes = response.data; //get all catalogs from category selected
      });
    }
  },
  mounted() {
    this.LoadCatalogFrecuency();
    this.LoadCatalogWorkType();
  }
}
</script>
