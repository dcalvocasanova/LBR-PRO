<template>
  <div class="hierarchy">
    <li>
    <div class="main"
      :class="{bold:isParent}"
      @click="toggle"
    >
      <h4>
        <span v-if="isParent">[{{ isOpen ? '-' : '+' }}]</span>
        {{ item.name }}
        <span v-if="!isParent" @click="makeParent"><i class="fa fa-plus-circle"></i> </span>
        <span class="controlls">
          <span @click="$emit('edit-node', item)"><i class="fas fa-edit"></i> </span>
          <span @click="$emit('delete-node', {'item':item, 'parent':parent})"><i class="fas fa-trash-alt"></i> </span>
        </span>
      </h4>

    </div>
    <ul v-show="isOpen" v-if="isParent">
      <tree-menu
        class="item"
        :parent="item"
        v-for="(child, index) in item.children"
          :key="index"
          :item="child"
          @make-parent="$emit('make-parent', $event)"
          @edit-node="$emit('edit-node', $event)"
          @delete-node="$emit('delete-node', $event)"
          @add-item="$emit('add-item', $event)"
      >
      </tree-menu>

      <li class="add" style="color:blue" @click="$emit('add-item', item)"><i class="fa fa-plus-circle"></i></li>

    </ul>
  </li>
  </div>
</template>

<script>
export default {
  name: 'tree-menu',
  props: {
    item: Object,
    parent: Object
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
}

li {
 list-style-type: none;
 padding: 5px 0;
}

.controls{
	display: none;
	position: absolute;
	top: 0;
	right: -56px;
	background: #black;
	z-index: 2;
	padding: 6px 10px 6px 6px;
}
.main:hover .controls{
	display: block;
}

</style>
