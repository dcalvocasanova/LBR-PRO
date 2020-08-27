<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0">Gestor Tiempos para cálculo de productividad</h4>
            <p> En esta sección seleccionamos cuales tiempos deben ser tomados en
              consideración para calcular el índice del modelo de eficiencia</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th> Tiempos </th>
                    <th> <button @click="saveTimes()" class="btn btn-success">Guardar</button></th>
                  </tr>
                </thead>
                <tbody>
                  <tr  v-for="time in Times.data" :key="time.id">
                    <td>
                      <input v-model="timesToAssign"
                             type="checkbox"
                             :name="time.id"
                             :value="time.id">  {{time.name}}
                    </td>
                  </tr>
                </tbody>
              </table>
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
          field_related:""
        }),
        Times:{},
        timesToAssign: [],
      }
    },
    methods:{
      loadTimes(page = 1) {
        let me = this
        axios.get('/parametros?page='+ page)
        .then(response => {
            me.loadFields()
            me.Times = response.data; //get all user's roles
        });
      },
      saveTimes(){
          let me =this;
          me.form.field_related = me.timesToAssign;
          me.form.post('/parametros/guardar-ineficiencia')
          .then(function (response) {
              swal.fire(
                'Información',
                'Se guardó los tiempos a utilizar en el cálculo de la ineficiencia',
                'success'
              )
          })
          .catch(function (error) {
              console.log(error);
          });

      },
      loadFields(){
        let me = this
        axios.get('/parametros/ineficiencia')
        .then(response => {
            me.timesToAssign = response.data;
        });
      },

    },
    created(){
      Fire.$on('searching',() => {
          toast.fire({
            type: 'WARNING',
            title: 'Las búsquedas se encuentran deshabilitadas en esta opción'
          });
        })
    },
    mounted() {
       this.loadTimes();
    }
  }
</script>
