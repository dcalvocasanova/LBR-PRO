<template>
  <div class="container container-project">
    <div class="row h-100" v-if="this.selectingProjectToAddTasks === true">
      <div class="card card-plain col-12">
        <div class="card-header card-header-primary ">
          <h4 class="card-title mt-0 "> Seleccione el proyecto donde se gestionaran las tareas y procedimientos asociados</h4>
        </div>
        <div class="card-body">
          <div class="form-group">
            <br>
            <select v-model="currentProject" class="form-control" @change="setProject()">
              <option v-for="p in Projects" :value="p.id">{{ p.name }}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-md-4 text-center">
		<button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Identificaciรณn: {{currentUserData.identification}}</button>
		<button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Nombre: {{currentUserData.name}}</button>
        <button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Jordada: {{workday}} min</button>
		<button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Puesto: {{currentUserData.position}}</button>
		<button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Nivel: {{currentUserData.relatedLevel}}</button>
		<button type="button" class="btn btn-outline-info btn-lg btn-block" disabled>Tiempo utilizado:{{tiempoUtilizado}} min</button>
      </div>
    </div>	
    <div class="row" v-if="this.selectingProjectToAddTasks === false">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-body ">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr><th> Tarea </th></tr>
                </thead>
                <tbody>
                  <tr v-for="t in Tasks" :key="t.id">
                    <tasks-measure
                    :task="t"
                    >
                  </tasks-measure>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <pagination :data="Tasks" @pagination-change-page="getTasks"></pagination>
        </div>
      </div>
    </div>
  </div>
	   <button
            class="btn btn-success"
            data-toggle="modal"
            data-target="#loadTask">
              Utilizar un archivo para cargar medidas de tareas
          </button>
	  
      <div class="modal fade" id="loadTask" tabindex="-1" role="dialog" aria-labelledby="loadUsersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ParameterModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Cargar timpos de tareas usando un archivo excel</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 m-2" >
                      <button class="btn btn-info btn-lg btn-block" v-on:click="onexport">Descargar plantilla</button>
                    </div>
                    <div class="col-12 mt-5">
                      <div class="form-group">
                        <label class="bmd-label-floating">Cargar archivo</label>
                        <input  type="file" id ="procesar_archivo" @change="EventSubir">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button data-dismiss="modal" class="btn btn-success">Regresar</button>
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
import JsonExcel from "vue-json-excel";
import XLSX from 'xlsx';
export default {
   components: {
    'downloadExcel':JsonExcel,
	  
  },
  data(){
    return{
      selectingProjectToAddTasks: false,
      tiempos:true,
      mejoramiento:false,
      currentProject:"",
      currentUser:"",
      Projects:{},
      Tasks:{},
      TaskElements:{},
      PHVA:{},
      Frecuencies:{},
      WorkTypes:{},
      AddedValue:{},
      Correlation:{},
      Risk:{},
      RiskCondition:{},
      OrganizationalSkills:{},
      Levels:{},
      level:"",
      type:"",
	  workday:"",
	  tiempoUtilizado:0,
	  currentUserData:{},
	  UserFieldsForExcel:{"Tarea":'tarea',"Medida":'medida'},
	  UserDataForExcel: []
    }
  },
  methods:{
	  
	onexport () { // On Click Excel download button
    
      // export json to Worksheet of Excel
      // only array possible
      var usersWS = XLSX.utils.json_to_sheet(this.UserDataForExcel) 
     // var pokemonWS = XLSX.utils.json_to_sheet(this.Datas.pokemons) 

      // A workbook is the name given to an Excel file
      var wb = XLSX.utils.book_new() // make Workbook of Excel

      // add Worksheet to Workbook
      // Workbook contains one or more worksheets
      XLSX.utils.book_append_sheet(wb, usersWS, 'usuarios') // sheetAName is name of Worksheet
      //XLSX.utils.book_append_sheet(wb, pokemonWS, 'pokemons')   

      // export Excel file
      XLSX.writeFile(wb, 'tareas.xlsx') // name of the file is 'book.xlsx'
	},	 
    getProjects(){
      let me =this;
      axios.get('/todos-los-proyectos')
      .then(response => {
        me.Projects = response.data; //get all projects from page
      });
    },
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.currentProject = response.data.id
        me.getCurrentUser()
       // me.LoadLevelsOfStructure()

      });
    },
	EventSubir(f){
        let me =this;
        me.taskFile = f.target.files[0];
        console.log(me.taskFile);
        var data = new FormData();
        data.append('archivo', me.taskFile);
        axios.post('/measures/loadmeasures', data, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      )
      .then(response => {
        toast.fire({
          type: 'success',
          title: 'Se cargó el archivo'
        });
      })
      .catch(function (error) {
        console.log(error);
        alert("Datos incompletos");
      });
    },
	getCurrentUser(){
      let me =this;
      axios.get('/usuario')
      .then(response => {
      me.currentUser = response.data.id
	  me.currentUserData = response.data
	  me.getUserTasks();
	  me.getWorday();
	  me.getUserTime();
	  me.getParametersTime();
      });
    },
	getUserTasks(page = 1) {
      let me =this;
      axios.get('/tareas-por-usuario',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
		let tasks =[]
        me.Tasks = response.data.data
		for (var i = 0; i < me.Tasks.length; i++) {
			let t = {}
			Vue.set(t ,'id',me.Tasks[i].id)
			Vue.set(t ,'tarea',me.Tasks[i].task)
			Vue.set(t ,'medida','')
			me.UserDataForExcel.push(t)
		}
      });
    },
	getWorday(){
		 let me =this;
      axios.get('/usuarios/workday',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.workday = response.data
		me.getExtendWorkday()
      });
	},
	getUserTime(){
		 let me =this;
      axios.get('/measures/tiempo',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.tiempoUtilizado += response.data
      });
	},
	getParametersTime(){
		 let me =this;
      axios.get('/parameter_measures/tiempo',{
        params:{
          id: me.currentUser
        }
      })
      .then(response => {
        me.tiempoUtilizado += response.data
      });
	},
    getTasks(page = 1) {
      let me =this;
      axios.get('/tareas-por-tipo',{
        params:{
          level: me.level,
          type: me.type,
          id: me.currentProject,
          page: page
        }
      })
      .then(response => {
        me.Tasks = response.data
      });
    },
	getExtendWorkday() {
      let me =this;
      axios.get('measure/jornada-extendida',{
        params:{
          relatedToLevel: me.level,
		  project_id: me.currentProject,
		 
        }
      })
      .then(response => {
		  if(response.data.extend)
        	me.workday = parseInt(me.workday) + parseInt(response.data.extend)
      });
    },
    setProject(){
      let me = this
      me.selectingProjectToAddTasks=false
      me.getTasks()
    },

  },
  mounted() {
    this.getCurrentProject()
  }
}
</script>
