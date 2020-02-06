<template>
  <ul class="treeview-list">
    <li class="treeview-item">
      <div class="main":class="{bold:isParent}" @click="toggle">
      <h4>
        <span v-if="isParent">[{{ isOpen ? '-' : '+' }}]</span>
        <span @click="$emit('clicked-node', item)">{{ item.name }}</span>
        <span class="controls-tree-edit" v-show="showTreeEditor">
          <span v-if="!isParent" @click="makeParent"><i class="fas fa-project-diagram"></i> </span>
          <span @click="$emit('edit-node', item)"><i class="fas fa-edit"></i> </span>
          <span @click="$emit('delete-node', {'item':item, 'parent':parent})"><i class="fas fa-trash-alt"></i> </span>
        </span>
        <span class="controls-gol-edit" v-show="showGoalEditor">
          <span @click="$emit('assign-inhetited-goal', {'item':item, 'parent':parent})"><i class="fas fa-clipboard-list"></i> </span>
		<span @click="$emit('assign-goal',item)"><i class="fas fa-columns"></i> </span>
        </span>
      </h4>
      </div>
      <ul class="nested-list" v-show="isOpen" v-if="isParent">
      <tree-menu
        class="item"
        :parent="item" :showTreeEditor="showTreeEditor" :showGoalEditor="showGoalEditor"
          v-for="(child, index) in item.children"
            :key="index"
            :item="child"
            @make-parent="$emit('make-parent', $event)"
            @clicked-node="$emit('clicked-node', $event)"
            @edit-node="$emit('edit-node', $event)"
            @delete-node="$emit('delete-node', $event)"
            @add-item="$emit('add-item', $event)"
            @assign-goal="$emit('assign-goal', $event)"
			@assign-inhetited-goal="$emit('assign-inhetited-goal', $event)"
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
    showGoalEditor: Boolean

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
