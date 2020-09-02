<template>
  <div class="container container-project">
    <div class="card card-plain">
      <div class="card-header card-header-primary">
        <h4 class="card-title mt-0">Niveles de estructura</h4>
      </div>
      <div class="card-body">
        <div class="tree-menu">
          <div class="tree-viewer">
            <tree-menu
              class="item" :item="Levels" :parent="Levels"
              :showTreeEditor="showAsStructureEditor" :showGoalEditor="showAsGoalEditor"
              :showMacroprocessesEditor="showAsMacroprocessEditor"
              @make-parent="makeParent"
              @edit-node="editNode"
              @delete-node="deleteNode"
              @add-item="addChild"
              @clicked-node="nodoSeleccionado"
              @assign-goal="asignarObjetivoANodo"
              @create-macroprocess="CreateMacroprocess"
              @relate-goal="relateGoals"
              @assign-inhetited-goal="asignarObjetivoHeredado"
              @edit-goal="editGoal"
              @edit-macroprocess="editMacroprocess"
              >
            </tree-menu>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button @click="saveLevel()" class="btn btn-success" data-dismiss="modal" aria-label="Close">Guardar estructura</button>
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
                            <td><input v-model=Macroprocessgoals type="checkbox" :name="goal.pos" :value="goal"> {{goal.name}}</td>
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
					  <label class="bmd-label-floating">Objetivo</label>
                      <input  v-model="newName" type="text" class="form-control">
                      <label class="bmd-label-floating">Código</label>
                      <input  v-model="newCode" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="container-buttons">
					<button v-if="updateNodeControl== 0" @click="addGoal()" class="btn btn-success">Añadir</button>
                      <button v-if="updateNodeControl!= 0" @click="updateGoal()" class="btn btn-info">Actualizar</button>
                      <button @click="exitGoalManager()" class="btn btn-secondary">Atrás</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="GoalEdit" tabindex="-3" role="dialog" aria-labelledby="GoalManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="GoalEdit"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-12">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Objetivo </th>
                    <th> Opciones </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="goal in currentNode.goals" :key="goal.code">
                    <td v-text="goal.name"></td>
                    <td>
                      <button class="btn btn-info" @click="loadGoalsUpdate(goal)"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-danger" @click="deleteGoal(goal)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="MacroprocessEdit" tabindex="-3" role="dialog" aria-labelledby="GoalManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="MacroprocessEdit"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-12">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Macroproceso </th>
                    <th> Opciones </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="macro in currentNode.macroprocess" :key="macro.code">
                    <td v-text="macro.name"></td>
                    <td>
					<button class="btn btn-info" @click="loadMacroprocessesUpdate(macro)"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" @click="deleteMacroprocess(macro)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="GoalEditManager" tabindex="-1" role="dialog" aria labelledby="TaskManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="TaskManager"> {{ title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4">
				  <div class="form-group">
					   <label class="bmd-label-floating">Nombre</label>
					   <input v-model="currentSelectedItem.name" >
					   <label class="bmd-label-floating">Código</label>
					   <input v-model="currentSelectedItem.code" >
				  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container-buttons">
              <button v-if="update == 0" @click="saveTask()" class="btn btn-success">Añadir</button>
              <button v-if="update != 0" @click="updateGoal()" class="btn btn-info">Actualizar</button>
              <button v-if="update != 0" @click="exitGoalEditManager()" class="btn btn-secondary">Atrás</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="MacroprocessEditManager" tabindex="-1" role="dialog" aria labelledby="TaskManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="MacroManager"> {{ title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">

              <div class="col-4">
				  
				 <div class="form-group">
					  <label class="bmd-label-floating">Nombre</label>
					  <input v-model="currentSelectedItem.name" >
				      <label class="bmd-label-floating">Código</label>
					  <input v-model="currentSelectedItem.code" >
				</div>
				  
				<label class="bmd-label-floating">Editar Objetivos Relacionados</label>
			  		<div v-for="goal in currentNode.goals" :key="goal.code">
			  			<td><input v-model="currentSelectedItem.goals"  v-bind:value="goal" type="checkbox"> {{goal.name}}</td>
					</div>
			  </div>  
              <div class="col-8">
                <!--<input v-model="currentSelectedItem.name" >-->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container-buttons">
              <button v-if="update != 0" @click="updateMacroprocess()" class="btn btn-info">Actualizar</button>
              <button v-if="update != 0" @click="exitUpdateMacroprocess()" class="btn btn-secondary">Atrás</button>
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
                  <button @click="salirRelacionarObjetivos()" class="btn btn-secondary">Salir</button>
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
            <h5 class="modal-title" id="TaskNotificator"> Relacionar Objetivos </h5>
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
                          <tr><th>Objetivos de nivel superior</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <select v-model="parentGoalName" class="form-control" @change="getRelatedGoals()">
					<option disabled value="">Seleccione un elemento</option>
                    <option v-for="goal in parentNode.goals" :value="goal.name" :key="goal.pos">{{ goal.name }}</option>
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
                          <tr><th>Seleccionar objetivos de nivel</th></tr>
                        </thead>
                        <tbody>
                          <tr v-for="currentgoal in currentNode.goals" :key="currentgoal.pos" >
                            <td>
                              <input v-model="relatedGoals" type="checkbox"
                                :value="currentgoal.name">
                                  {{currentgoal.name}}
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
          <div class="modal-footer">
            <div class="card-body">
                <div class="container-buttons">
                  <button  @click="saveRelation()" class="btn btn-success">Enviar</button>
                  <button @click="exitRelatedManager()" class="btn btn-secondary">Salir</button>
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
    showAsMacroprocessEditor: Boolean
  },
  data(){
    return{
      project_id:"",
      goalsInherited:[],
      relatedGoals:[],
	  ////////////////////
      parentGoals:[],
	  currentGoals:[],
	  parentGoalName:"",	
      temp:[],
      currentSelectedItem:"",
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
    },
    asignarObjetivoANodo(item){
      let me = this;
	 me.relatedGoals=[]
      me.currentNode = item
      me.updateNodeControl = 0
      this.getGoalName()
	  me.relatedGoals = []
	  me.title="Actualizar información del objetivo";
    },
    relateGoals(nodo){
	  let me = this;
	  me.relatedGoals = []	
	  me.currentNode = nodo.item
	  me.parentNode = nodo.parent
	  me.parentGoals = me.parentNode.goals
	  me.CurrentGoals = me.currentNode.goals
	  me.updateNodeControl = 0
	  this.getGoals()
    },
	getRelatedGoals(){
		let me = this;
		axios.get('measures/getRelatedGoals',{
        params:{
		  project_id: me.project_id,
		  relatedLevel:me.currentNode.name,
		  parentGoal:me.parentGoalName		
        }
      })
      .then(response => {
		   me.relatedGoals = JSON.parse(response.data.currentGoals)
      });
	},
    loadGoalsUpdate(goal){
      let me = this;
      me.currentSelectedItem = goal
      me.title="Actualizar información del objetivo";
      me.update = 1;
      $('#GoalEditManager').modal('show');

    },
    updateGoal(){
      $('#GoalEditManager').modal('toggle');
		this.saveLevel();

    },
	 exitUpdateGoal(){
		 $('#GoalEditManager').modal('toggle');
	 },
    deleteGoal(item){
      let me = this;
      swal.fire({
        title: 'Eliminar un objetivo',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un objetivo",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          me.currentNode.goals = me.deleteIndex(me.currentNode.goals,item)
          swal.fire(
            'Eliminado',
            'Objetivo fue eliminado',
            'success'
          )
        }
      })

    },
    deleteIndex(arr, index){
      return arr.filter(function(i){
        return i!= index
      });
    },
    deleteMacroprocess(item){
      let me = this;
      swal.fire({
        title: 'Eliminar un macroproceso',
        text: "Esta acción no se puede revertir, Está a punto de eliminar un macroproceso",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#114e7e',
        cancelButtonColor: '#20c9a6',
        confirmButtonText: '¡Sí, eliminarlo!'
      })
      .then((result) => {
        if (result.value) {
          me.currentNode.macroprocess = me.deleteIndex(me.currentNode.macroprocess,item)
          swal.fire(
            'Eliminado',
            'macroproceso fue eliminado',
            'success'
          )
        }
      })

    },
    loadMacroprocessesUpdate(macro){
      let me = this;
      me.currentSelectedItem = macro
      me.title="Actualizar información del Macroproceso";
      me.update = 1;
      $('#MacroprocessEditManager').modal('show');

    },
    updateMacroprocess(){
      $('#MacroprocessEditManager').modal('toggle');
	  this.saveLevel();
		
    },
	 exitUpdateMacroprocess(){
      $('#MacroprocessEditManager').modal('toggle');
		
    },
    exitMacroprocess(){
      $('#GoalEditManager').modal('toggle');
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
      if(node.parent !==node.item){ } else{ node.parent.children = [] }
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
	saveRelation(){
		let me = this
	    axios.put('/estructura/objetivos-relacionados',{
			
				project_id: me.project_id,
			    level:me.currentNode.name,
				parentGoal:me.parentGoalName,
				currentGoals: JSON.stringify(me.relatedGoals)
		    
		})
	    .then(function (response) {
		  toast.fire({
		   type: 'success',
		   title: 'Elementos de la tarea agregados con éxito'
		  });
       })
     },
    updateLevel(){
      let me = this;
      me.level.put('/estructura/actualizar')
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
    },
    salirObjetivos(){
      $('#GoalManager').modal('toggle');
      this.newName = ""
    },
    salirRelacionarObjetivos(){
      $('#InheritedManager').modal('toggle');
      this.newName = ""
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
    editGoal(item){
      let me =this;
      me.currentNode = item
      me.updateNodeControl = 0
      //this.getGoalName()
      $('#GoalEdit').modal('show')
    },
    editMacroprocess(item){
      let me =this;
      me.currentNode = item
      me.updateNodeControl = 0
      //this.getGoalName()
      $('#MacroprocessEdit').modal('show')
    },
    getGoalName(){
      $('#GoalManager').modal('show')
    },
    rndStr(len) {
      let text = " "
      let chars = "abcdefghijklmnopqrstuvwxyz123456789"
      },
      addGoal() {
        let me = this;
		if(me.newCode.trim()!="" && me.newName.trim()!=""){
				me.currentNode.numGoals += 1
				me.currentNode.goals.push({
				  code: me.newCode,
				  name: me.newName,
				  pos:me.currentNode.numGoals, // definir contador para objetivos
				  objectCode:me.rndStr(7)
				})
				me.title= "Agregar Objetivo"
				me.salirObjetivos()
	     }else{
				swal.fire(
				  'Datos incompletos',
				  'Es necesario seleccionar código y un nombre para registrar el objetivo',
				  'warning'
        )
      }
      },
	    addMacroprocess() {
        	let me = this;
			if(me.newCode.trim()!="" && me.newName.trim()!=""){
				me.currentNode.macroprocess.push({
				  code: me.newCode,
				  name: me.newName,
				  goals: me.Macroprocessgoals // definir contador para objetivos
				})
        		me.salirMacroprocess()
			}else{
				swal.fire(
				  'Datos incompletos',
				  'Es necesario seleccionar objetivos, codigo y un nombre para registrar el macroproceso',
				  'warning'
   			     )
     		 }
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
      },
      exitGoalManager(){
      $('#GoalManager').modal('toggle');
        this.newName = ""
		this.newCode = ""
	    this.salir()
      },
	  exitRelatedManager(){
      $('#RelatedManager').modal('toggle');
        this.newName = ""
		this.newCode = ""
		this.salir()

      },
      salirRelacionarObjetivos(){
        $('#InheritedManager').modal('toggle');
        this.newName = ""
      },
	  exitGoalEditManager(){
        $('#GoalEditManager').modal('toggle');
         this.newName = ""
		 this.newCode = ""
      },
	    salirMacroprocess(){
        $('#MacroprocessManager').modal('toggle');
        this.newName = ""
        this.newCode = ""
	    this.Macroprocessgoals = []
		this.salir()

      },
      getMacroprocessData(){
        $('#MacroprocessManager').modal('show')
        this.newName = ""
        this.newCode = ""
		this.Macroprocessgoals = []
		this.salir()
      },
	    getNodeName(){
        $('#LevelManager').modal('show')
        this.newName = ""
        this.newCode = ""
      },
      getGoalsInherited(){
        $('#InheritedManager').modal('show')
      },
	  editGoal(item){
		  let me =this;
          me.currentNode = item
          me.updateNodeControl = 0
        $('#GoalEdit').modal('show')
      },
	 editMacroprocess(item){
		   let me =this;
          me.currentNode = item
          me.updateNodeControl = 0
          //this.getGoalName()
        $('#MacroprocessEdit').modal('show')
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
    },
    getCurrentProject(){
      let me =this;
      axios.get('/proyecto/actual')
      .then(response => {
        me.project_id = response.data.id
        me.level.project_id= me.project_id
        me.getLevels()
      });
    },
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
    this.getCurrentProject();
  }
}
</script>
<style>
.modal-body {
  max-height: calc(100vh - 210px);
  overflow-y: auto;
}
</style>
