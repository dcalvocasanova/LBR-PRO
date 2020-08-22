<template>
  <div class="container container-project">
    <div class="col-md-12">
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-products" role="tabpanel" aria-labelledby="pills-products-tab">
          <table class="table">
           <thead>
              <th class="text-center"> Niveles </th>
              <th> Aumentar jornada </th>
            </thead>
            <tbody>
                <tr v-for="l in Levels" :key="l.id" >
                  <td>
                    <span v-text="l">:</span>
                  </td>
                  <td>
                    <button class="btn btn-info" @click="getUsersInLevel(l)"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal fade" id="TaskNotificator" tabindex="-1" role="dialog" aria labelledby="TaskNotificator-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="TaskNotificator">Tiempo de jornada</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="form-group">
                      <table class="table table-hover">
                       <thead>
                          <tr><th>Usuarios del nivel</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <select v-model="form.user" class="form-control" @chanche="getUsersInTemplate(form.relatedTemplate)">
                    <option v-for="user in Users" :key="user.id" :value="user.id" >{{ user.name }}</option>
                  </select>
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
                  <div class="card-body">
                    <div class="form-group">
                      <table class="table table-hover">
                       <thead>
                          <tr><th>Aumentar jornada en</th></tr>
                        </thead>
                        <tbody>
                          <td><input v-model="form.extend" type="text"> minutos</td>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
			  <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Fecha de aplicación</label>
                  <input type="date" v-model="form.fecha"
                    class="form-control":class="{ 'is-invalid': form.errors.has('fecha') }">
                  <has-error :form="form" field="fecha"></has-error>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="card-body">
                <div class="container-buttons">
                  <button  @click="saveExtend()" class="btn btn-success">Enviar</button>
                  <button @click="exit()" class="btn btn-secondary">Salir</button>
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
          title:"Aumentar Jornada",
          project_id: '',
          relatedToLevel:'',
		  user:"",
		  extend:"",
		  fecha:""
        }),
        currentProject:0,
        relatedToLevel:'',
		Users:{},
		Levels:{}
      }
  },
  methods:{
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
          me.currentProject = response.data.id
          me.form.project_id = me.currentProject
		  me.LoadLevelsOfStructure()
      });
    },

	/////////////////////////////////////////////////////////// TemplatesUser
	LoadLevelsOfStructure() {
      let me = this
      axios.get('/estructura/lista-niveles/'+this.currentProject)
      .then(response => {
            me.Levels = response.data; //get all catalogs from category selected
      });
    },
	getUsersInLevel(level){
      axios.get('/usuarios-por-nivel', {
          params: {
            project: this.currentProject,
            level: level
          }
      })
      .then(response => {
        this.Users = response.data; //get all projects from page
		this.form.relatedToLevel = level
        $('#TaskNotificator').modal('show');
      });
    },
    exit(){
        $('#TaskNotificator').modal('toggle');
        this.form.reset()
    },
	saveExtend(){
		let me = this
	  me.form.project_id = me.currentProject
      me.form.put('/measures/extender-jornada')
      .then(function (response) {
         toast.fire({
          type: 'success',
          title: 'Elementos de la tarea agregados con éxito'
         });
      })
	}
  },
  mounted() {
    this.getCurrentProject()
  }
}
</script>
