<template>
  <div class="container container-project">
    <div class="row">
        <div class="col-md-12">
          <div class="card card-plain">
            <div class="card-header card-header-primary">
              <h4 class="card-title mt-0"> Lista de proyectos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="">
                    <tr>
                      <th> Nombre </th>
                      <th> Logo </th>
                      <th> Niveles de estructura </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="project in Projects.data" :key="project.id" >
                        <td v-text="project.name"></td>
                        <td style="width: 80px;"> <img  class="img-profile-pic rounded-circle" :src="getLogo(project)" alt="Project logo"/> </td>
                        <td>
                            <button class="btn btn-primary" @click="loadLevelData(project)" data-toggle="modal" data-target="#addLevels"><i class="fas fa-swatchbook"> Niveles de estructura</i></button>
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
            <h5 class="modal-title" id="LevelModalOptions">Niveles de estructura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <button @click="saveLevel()" class="btn btn-success" data-dismiss="modal" aria-label="Close">Guardar estructura</button>
            <br><br>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="tree-menu">
                    <div class="tree-viewer">
                      <tree-menu
                        class="item" :item="Levels":parent="Levels"
                        :showTreeEditor="true" :showGoalEditor="true"
                        @make-parent="makeParent"
                        @edit-node="editNode"
                        @delete-node="deleteNode"
                        @add-item="addChild"
                        @clicked-node="nodoSeleccionado"
                        @assign-goal="asignarObjetivoANodo"
                      >
                      </tree-menu>
                    </div>
                    <div class="modal fade" id="LevelManager" tabindex="-1" role="dialog" aria-labelledby="LevelManager-lg" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="LevelManager"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-8">
                                        <div class="form-group">
                                          <label class="bmd-label-floating">Nombre</label>
                                          <input  v-model="newName" type="text" class="form-control">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
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
                      </div>
                    </div>
                  </div>
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
    data(){
      return{
        project_id:0,
        update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
        Projects:{}, //All registered projects
        Levels:{}, // All levels from organization
        currentNode: {}, //Current node to update or add
        updateNodeControl:0, //
        newName:"",
        level: new Form({
          id:"", //level projectID
          levels:"",
          project_id:""
        })
      }
    },
    methods:{
      nodoSeleccionado(item){
        alert ("Se hizo click sobre"+item.name)
      },
      asignarObjetivoANodo(item){
        alert ("Se quiere ingresar objetivo al nodo "+item.name)
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
        me.updateNodeControl = 0
        Vue.set(item, 'children', [])
        this.getNodeName()
      },
      addChild(item) {
        let me = this;
        me.currentNode = item
        me.updateNodeControl = 0
        this.getNodeName()
      },
      editNode(item){
        let me = this;
        me.currentNode = item
        me.newName = me.currentNode.name
        me.updateNodeControl = 1
        this.getNodeName()
      },
      addNode() {
        let me = this;
        me.currentNode.children.push({
          name: me.newName,
          level:me.currentNode.level + 1
        })
        me.salir()
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
      getNodeName(){
        $('#LevelManager').modal('show')
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
