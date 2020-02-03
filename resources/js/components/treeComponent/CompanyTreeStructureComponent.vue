<template>
  <div class="tree-menu">
    <div class="tree-viewer">
      <tree-menu
        class="item"
        :item="treeData"
        :parent="treeData"
        @make-parent="makeParent"
        @edit-node="editNode"
        @delete-node="deleteNode"
        @add-item="addChild"
      >
      </tree-menu>
    </div>
    <div class="modal fade" id="getData" tabindex="-1" role="dialog" aria-labelledby="ParamatersModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ParameterModalLabel">Niveles de estructura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title"> </h4>
                  </div>
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
</template>

<script>
    var treeData = {
    name: 'Estructura de niveles',
    level: 0
    }
  export default {
    data() {
      return{
          treeData: treeData,
          currentNode: {},
          updateNodeControl:0,
          newName:""
      }
    },
    methods: {
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
        $('#getData').modal('toggle');
        this.newName = ""
      },
      getNodeName(){
        $('#getData').modal('show')
      },
    }
  }
</script>
