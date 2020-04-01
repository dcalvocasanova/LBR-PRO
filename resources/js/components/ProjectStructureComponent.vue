<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0">Lista de proyectos</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th>Nombre</th>
                    <th>Logo</th>
                    <th>Niveles de estructura</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="project in Projects.data" :key="project.id" >
                    <td v-text="project.name"></td>
                    <td style="width: 80px;"> <img  class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                    <td>
                      <button class="btn btn-primary" @click="loadLevelData(project)" data-toggle="modal" data-target="#addLevels"><i class="fas fa-swatchbook">Niveles de estructura</i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Projects" @pagination-change-page="getProjectsPaginator"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addLevels" tabindex="-1" role="dialog" aria-labelledby="LevelModalOptions-lg" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h2 class="modal-title" @click="saveLevel()" id="LevelModalOptions">Niveles de estructura del proyecto</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="tree-menu">
                    <div class="tree-viewer">
                      <tree-menu
                        class="item" :item="Levels":parent="Levels"
                        :showTreeEditor="showAsStructureEditor"
                        :showGoalEditor="showAsGoalEditor"
                        :justShowTree="justShowTree"
                        @make-parent="makeParent"
                        @edit-node="editNode"
                        @delete-node="deleteNode"
                        @add-item="addChild"
                        @clicked-node="nodoSeleccionado"
                        @assign-goal="asignarObjetivoANodo"
            						@create-macroprocess="CreateMacroprocess"
            						@relate-goal="relateGoals"
                        @assign-inhetited-goal="asignarObjetivoHeredado"
                      >
                      </tree-menu>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button @click="saveLevel()" class="btn btn-success" data-dismiss="modal" aria-label="Close">Guardar estructura</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="LevelManager" tabindex="-2" role="dialog" aria-labelledby="LevelManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="LevelManager"> {{title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">Nombre</label>
                      <input  v-model="newName" type="text" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="container-buttons">
                    <button v-if="updateNodeControl== 0" @click="addNode()" class="btn btn-success">Añadir</button>
                    <button v-if="updateNodeControl!= 0" @click="updateNode()" class="btn btn-info">Actualizar</button>
                    <button @click="salir()" class="btn btn-secondary">Atrás</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="MacroprocessManager" tabindex="-2" role="dialog" aria labelledby="MacroprocessManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="LevelManager">{{title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="form-group">
	                    <label class="bmd-label-floating">Nombre</label>
                      <input  v-model="newName" type="text" class="form-control">
                      <label class="bmd-label-floating">Código</label>
                      <input  v-model="newCode" type="text" class="form-control">
		                  <table class="table table-hover">
                       <thead class="">
      										<tr>
      										  <th>Seleccione los objetivos asociados</th>
      										</tr>
                      </thead>
    								  <tbody>
      										<tr v-for="goal in currentNode.goals" :key="goal.pos" >
												<td><input v-model=Macroprocessgoals type="checkbox" :name="goal.pos" :value="goal.pos"> {{goal.name}}</td>
      										</tr>
    								  </tbody>
  					        </table>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="container-buttons">
                    <button v-if="updateNodeControl== 0" @click="addMacroprocess()" class="btn btn-success">Añadir</button>
                    <button v-if="updateNodeControl!= 0" @click="updateNode()" class="btn btn-info">Actualizar</button>
                    <button @click="salirMacroprocess()" class="btn btn-secondary">Atrás</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="GoalManager" tabindex="-3" role="dialog" aria-labelledby="GoalManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="GoalManager"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label class="bmd-label-floating">Código</label>
                      <input  v-model="newCode" type="text" class="form-control">
                      <label class="bmd-label-floating">Objetivo</label>
                      <input  v-model="newName" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="container-buttons">
                      <button v-if="updateNodeControl== 0" @click="addGoal()" class="btn btn-success">Añadir</button>
                      <button v-if="updateNodeControl!= 0" @click="updateGoal()" class="btn btn-info">Actualizar</button>
                      <button @click="salirObjetivos()" class="btn btn-secondary">Atrás</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="InheritedManager" tabindex="-4" role="dialog" aria-labelledby="InheritedManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="InheritageManager"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="col-md-8">
                  <div class="form-group">
                    <table class="table table-hover">
                       <thead class="">
      										<tr>
      										  <th> Seleccione los objetivos </th>
      										</tr>
                      </thead>
    								  <tbody>
      										<tr v-for="goal in parentNode.goals" :key="goal.pos" >
												<td><input v-model=currentNode.inheritedGoals type="checkbox" :name=goal.pos :value=goal.pos> {{goal.name}}</td>
      										</tr>
    								  </tbody>
  					        </table>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="container-buttons">
                  <button @click="salirManejador()" class="btn btn-secondary">Salir</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	  <div class="modal fade" id="RelatedManager" tabindex="-4" role="dialog" aria-labelledby="RelatedManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="InheritageManager"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="col-md-8">
                  <div class="form-group">
                    <table class="table table-hover">
                       <thead class="">
    										<tr>
      										  <th > Objetivos del nivel superior </th>
      										  <th > Objetivos de este nivel </th>
      									</tr>
                      </thead>
                      <tbody >
                        <tr v-for="rows in relatedGoals">
                          <td v-for="goal in rows">
                            <input
                              type="checkbox"
                              v-model="goal.related"
                              v-bind:key="goal.randomCellIndex"
                              :value="goal.randomCellIndex">
                              {{goal.name}}
                          </td>
                        </tr>
                      </tbody>
  					        </table>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="container-buttons">
                  <button @click="salirRelacionarObjetivos()" class="btn btn-secondary">Salir</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="NotificatorManager" tabindex="-4" role="dialog" aria-labelledby="RelatedManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="InheritageManager"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <notificator-goals-chekimg
                :Item=currentNode
                @close-modal="salirNotificador"
                ></notificator-goals-chekimg>
              </div>
              <div class="card-footer">
                <div class="container-buttons">
                  <button @click="salirNotificador()" class="btn btn-secondary">Salir</button>
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
	props:{
      showAsStructureEditor: Boolean,
      showAsGoalEditor: Boolean,
      justShowTree: Boolean
    },
    data(){
      return{
        project_id:0,
        goalsInherited:[],
		    relatedGoals:[],
	      relatedTest:[[]],
        temp:[],
	      Macroprocessgoals:[],
        update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
        Projects:{}, //All registered projects
        Levels:{}, // All levels from organization
        currentNode: {}, //Current node to update or add
	      parentNode: {}, //Parent node to update or add
        updateNodeControl:0, //
	      itemsCopy:[],
        title:"",
        newName:"",
		    newCode:"",
        level: new Form({
          id:"", //level projectID
          levels:"",
          project_id:""
        })
      }
    },
    methods:{
      nodoSeleccionado(item){
        if(this.justShowTree){
            $('#NotificatorManager').modal('show')
            this.currentNode = item
        }
      },
      asignarObjetivoANodo(item){
        let me = this;
        me.currentNode = item
        me.updateNodeControl = 0
        this.getGoalName()
      },
	    relateGoals(nodo){
        let me = this;
        me.currentNode = nodo.item
        me.parentNode = nodo.parent
        me.updateNodeControl = 0
        me.relatedGoals= []
		    // Empty two random cells per row
        for (var i = 0; i < me.parentNode.goals.length; ++i) {
		      let temp1 = [];
	        me.relatedGoals.push(temp1);
          me.relatedGoals[i].push(me.parentNode.goals[i]);
			      for (var k = 0; k < me.parentNode.goals.length; ++k) {
            	me.relatedGoals[i].push(me.currentNode.goals[k]);
          	}
        }
		     // Empty two random cells per row
        for (var i = 0; i < me.relatedGoals.length; ++i) {
          for (var k = 0; k < me.relatedGoals[i].length; ++k) {
			      me.itemsCopy = me.relatedGoals.slice();
   			    var obj = Object.assign({}, me.itemsCopy[i][k]);


				let randomCellIndex = me.rndStr(15);
   				obj.randomCellIndex = randomCellIndex;
				obj.related = "";
    			me.itemsCopy[i][k] = obj;  //replace the old obj with the new modified one.

                }
            }

          this.getGoals()
        },
      CreateMacroprocess(item){
          let me = this;
          me.currentNode = item
          me.updateNodeControl = 0
		  me.title= "Agregar Macroproceso"
          this.getMacroprocessData()
        },
  	  asignarObjetivoHeredado(nodo){
        let me = this;
        me.currentNode = nodo.item
	      me.parentNode = nodo.parent
        me.updateNodeControl = 0
        this.getGoalsInherited()
      },
      addObjetivoHeredado(node){
        let me = this;
        if(node.parent !==node.item){

        }
        else{
          node.parent.children = []
        }
      },
      getProjectsPaginator(page = 1) {
        axios.get('/proyectos?page=' + page)
        .then(response => {
              this.Projects = response.data; //get all projects from page
        });
      },
      getLogo(project){
        let logo = (project.logo_project.length > 200) ? project.logo_project : "/img/profile-prj/"+ project.logo_project ;
        return logo;
      },
      getProjects(){
        let me =this;
        axios.get('/proyectos').then(function (response) {
            me.Projects = response.data; //get all projects
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      getResultLevel(page = 1){
        axios.get('/estructura?page=' + page)
        .then(response => {
              this.Levels = response.data; //get all projects from page
        });
      },
      getLevels(){
          let me =this;
          let url = '/estructura?id='+me.project_id;
          axios.get(url).then(function (response) {
              me.Levels = JSON.parse(response.data.levels); //get all structure

              me.level.id= response.data.id;
              me.level.project_id=response.data.project_id;
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      saveLevel(){
        let me =this
        me.level.levels =JSON.stringify(me.Levels)
        me.updateLevel()
      },
      updateLevel(){
          let me = this;
          this.level.put('/estructura/actualizar')
          .then(function (response) {
             toast.fire({
              type: 'success',
              title: 'Niveles de estructura registrado con éxito'
             });
             me.level.reset()
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      loadLevelData(project){
          this.project_id = project.id;
          this.getLevels();
      },
      makeParent(item) {
        let me = this;
        me.currentNode = item
		me.currentNode.featherNode=false
        me.updateNodeControl = 0
        Vue.set(item, 'children', [])
        this.getNodeName()
      },
      addChild(item) {
        let me = this;
        me.getNodeName()
        me.currentNode = item
        me.updateNodeControl = 0
        me.title= "Agregar nivel de estructura"

      },
      editNode(item){
        let me = this
        me.getNodeName()
        me.currentNode = item
        me.newName = me.currentNode.name
        me.title= "Modificar nombre del nivel de estructura"
        me.updateNodeControl = 1

      },
      addNode() {
        let me = this
        me.currentNode.children.push({
          name: me.newName,
          level:me.currentNode.level + 1,
    		  numGoals:0,
			    featherNode:true,
    		  goals:[],
    		  inheritedGoals:[],
			    macroprocess:[],
          userFunctions:[]
        })
        me.salir()
      },
      addGoal() {
        let me = this;
	      me.currentNode.numGoals += 1
        me.currentNode.goals.push({
  	      code: me.newCode,
          name: me.newName,
          pos:me.currentNode.numGoals, // definir contador para objetivos
          objectCode:me.rndStr(7)
        })
		me.title= "Agregar Objetivo"
        me.salirObjetivos()
      },
	    addMacroprocess() {
        let me = this;
        me.currentNode.macroprocess.push({
	      code: me.newCode,
          name: me.newName,
          goals: me.Macroprocessgoals // definir contador para objetivos
        })
        me.salirMacroprocess()
      },
	    RelacionarObjetivos(){
        let me = this
        me.currentNode.inheritedGoals.push({
	        goals: me.goalsInherited
        })
	    me.title= "Relacionar objetivos"
        me.salirRelacionarObjetivos()
      },
      updateNode() {
        let me = this
        me.currentNode.name = me.newName
        me.salir()
      },
      deleteNode(node){
        let me = this;
        if (node.parent !==node.item){
          node.parent.children= me.deleteIndex(node.parent.children,node.item)
        }
        else{
          node.parent.children = []
        }
      },
      deleteIndex(arr, index){
        return arr.filter(function(i){
          return i!= index
        });
      },
      salir(){
        $('#LevelManager').modal('toggle');
        this.newName = ""
        this.newCode = ""
      },
      salirObjetivos(){
        $('#GoalManager').modal('toggle');
        this.newName = ""
        this.newCode = ""
      },
      salirManejador(){
        $('#InheritedManager').modal('toggle');
        this.newName = ""
        this.newCode = ""
      },
      salirNotificador(){
        $('#NotificatorManager').modal('toggle');
      },
      salirRelacionarObjetivos(){
        $('#RelatedManager').modal('toggle');
        this.newName = ""
        this.newCode = ""
      },
	    salirMacroprocess(){
        $('#MacroprocessManager').modal('toggle');
        this.newName = ""
        this.newCode = ""
	      this.Macroprocessgoals = []
      },
      getMacroprocessData(){
        $('#MacroprocessManager').modal('show')
        this.newName = ""
        this.newCode = ""
		    this.Macroprocessgoals = []
      },
	    getNodeName(){
        $('#LevelManager').modal('show')
        this.newName = ""
        this.newCode = ""
      },
      getGoalsInherited(){
        $('#InheritedManager').modal('show')
      },
      getGoals(){
          $('#RelatedManager').modal('show')
        },
      getGoalName(){
          $('#GoalManager').modal('show')
        },
      rndStr(len) {
      	let text = " "
      	let chars = "abcdefghijklmnopqrstuvwxyz123456789"

       	 for( let i=0; i < len; i++ ) {
  			 for(let k=0; k < 8; k++ ){
  				text += chars.charAt(Math.floor(Math.random() * chars.length))
  		     }
        	}

    		return text
  	  }
    },
    created(){
      Fire.$on('searching',() => {
        let query = this.$parent.search;
        axios.get('/findproject?q=' + query)
        .then((response) => {
            this.Projects = response.data
        })
        .catch(() => {
        })
      })
    },
    mounted() {
     this.getProjects();
    }
  }
</script>

<style>
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>
