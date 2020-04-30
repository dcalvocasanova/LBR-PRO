<template>
  <ul class="treeview-list">
    <li class="treeview-item">
      <div class="main":class="{bold:isParent}" @doubleclick="toggle">
      <h4>
        <span v-if="isParent">[{{ isOpen ? '-' : '+' }}]</span>
        <span @click="$emit('clicked-node', item)">{{ item.name }}</span>
        <span class="controls-tree-edit" v-show="showTreeEditor">
          <span v-if="!isParent" @click="makeParent"><i class="fas fa-project-diagram"></i> </span>
          <span @click="$emit('edit-node', item)"><i class="fas fa-edit"></i> </span>
          <span @click="$emit('delete-node', {'item':item, 'parent':parent})"><i class="fas fa-trash-alt"></i> </span>
        </span>


		  
        	<span class="controls-gol-edit" v-show="showGoalEditor">
			<button class="btn btn-primary" @click="$emit('assign-goal',item)" data-toggle="tooltip" >
            <i class="fas fa-columns">Asignar objetivo</i>
            </button>	
			
			<button class="btn btn-primary" @click="$emit('relate-goal', {'item':item, 'parent':parent})" data-toggle="tooltip" >
            <i class="fas fa-columns">Relacionar objetivos</i>
            </button>
				
			
       </span>   

        <span class="controls-gol-edit" v-show="showUserFunctionsEditor">
            <button class="btn btn-primary"
              @click="$emit('create-user-function',item)"
              data-toggle="tooltip"
              data-placement="top"
              title="Agregar nueva funciรณn">
              <i class="fas fa-plus-circle"></i>
            </button>
            <button class="btn btn-primary"
              @click="$emit('modify-user-function',item)"
              data-toggle="tooltip"
              data-placement="top"
              title="Agregar nueva funciรณn">
              <i class="fas fa-edit"></i>
            </button>
        </span>
		<span class="controls-gol-edit" v-show="showMacroprocessesEditor">
			<button class="btn btn-primary" @click="$emit('create-macroprocess',item)" data-toggle="tooltip">
            <i class="fas fa-connectdevelop">Crear Macroproceso</i>
            </button>
	    </span>

      </h4>
      </div>
      <ul class="nested-list" v-show="isOpen" v-if="isParent">
      <tree-menu
        class="item"
        :parent="item"
        :showTreeEditor="showTreeEditor"
        :showGoalEditor="showGoalEditor"
        :showUserFunctionsEditor="showUserFunctionsEditor"
	    :showMacroprocessesEditor= "showMacroprocessesEditor"
          v-for="(child, index) in item.children"
            :key="index"
            :item="child"
            @make-parent="$emit('make-parent', $event)"
            @clicked-node="$emit('clicked-node', $event)"
            @edit-node="$emit('edit-node', $event)"
            @delete-node="$emit('delete-node', $event)"
            @add-item="$emit('add-item', $event)"
            @assign-goal="$emit('assign-goal', $event)"
            @create-macroprocess="$emit('create-macroprocess', $event)"
            @assign-inhetited-goal="$emit('assign-inhetited-goal', $event)"
            @relate-goal="$emit('relate-goal', $event)"
            @create-user-function="$emit('create-user-function',$event)"
            @modify-user-function="$emit('modify-user-function',$event)"

      >
      </tree-menu>
      <li class="add" v-show="showTreeEditor" style="color:blue" @click="$emit('add-item', item)"><i class="fa fa-plus-circle"></i></li>
    </ul>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'tree-menu',
  props: {
    item: Object,
    parent: Object,
    showTreeEditor: Boolean,
    showGoalEditor: Boolean,
    showUserFunctionsEditor: Boolean,
	showMacroprocessesEditor: Boolean
  },
  data() {
    return {
      isOpen: true
    }
  },
  computed: {
   isParent() {
     return this.item.children &&
       this.item.children.length
     }
   },
  methods: {
    toggle() {
      if (this.isParent) {
        this.isOpen = !this.isOpen
      }
    },
    makeParent() {
      let me = this;
      me.item.isOpen = true
    	me.$emit('make-parent', me.item)
    }
  }
}
</script>

<style scoped>
.type {
  margin-right: 10px;
}

ul{
    list-style-type: none;
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}
li{
  display: list-item;
  text-align: -webkit-match-parent;
}

.treeview-list ul {
    position: relative;
    padding-left: 1em;
    list-style: none;
}
.treeview-item{
    padding: .2em .2em .2em .6em;
    cursor: pointer;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    -webkit-transition: all .1s linear;
    transition: all .1s linear;
}
.nested-list::before{
  position: absolute;
  left: 2px;
  display: block;
  width: 6px;
  height: 100%;
  content: "";
  background-color: #808070;
  box-sizing: border-box;
}

.item{
  width: 100%
}

.control{
	display: none;
  position: absolute;
	top: 1;
	left: 10%;
	background: #black;
	z-index: 2;
	padding: 6px 10px 6px 6px;
}
.main:hover .control{
	display: block;
}

</style>
