<template>
  <div>
    <li>
    <div
      :class="{bold: isParent}"
      @click="toggle"
    >
      <span v-if="isParent">[{{ isOpen ? '-' : '+' }}]</span>
      {{ item.name }}
      <button class="btn btn-success">{{ item.name }}</button>
      <span v-if="!isParent" @click="makeParent"><i class="fa fa-plus-circle"></i> </span>
      <span @click="$emit('edit-node', item)"><i class="fas fa-edit"></i> </span>
      <span @click="$emit('delete-node', item)"><i class="fas fa-trash-alt"></i> </span>
    </div>
    <ul v-show="isOpen" v-if="isParent">
      <tree-menu
        class="item"
        v-for="(child, index) in item.children"
        :key="index"
        :item="child"
        @make-parent="$emit('make-parent', $event)"
        @edit-node="$emit('edit-node', $event)"
        @delete-node="$emit('delete-node', $event)"
        @add-item="$emit('add-item', $event)"
      >
      </tree-menu>
      <li class="add" @click="$emit('add-item', item)"><i class="fa fa-plus-circle"></i></li>

    </ul>
  </li>
  </div>
</template>

<script>
export default {
  name: 'tree-menu',
  props: {
    item: Object
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
.node {
  text-align: left;
  font-size: 18px;
}
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

</style>
