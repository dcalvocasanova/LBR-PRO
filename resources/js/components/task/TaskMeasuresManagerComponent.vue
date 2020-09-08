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
	  <button type="button" v-on:click="onexport">Descargar plantilla</button>
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
	  UserFieldsForExcel:{},
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
			//let t = me.Tasks[i].task
			Vue.set(me.UserFieldsForExcel,me.Tasks[i].task,' ')
		}
		me.UserDataForExcel.push(me.UserFieldsForExcel)
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
