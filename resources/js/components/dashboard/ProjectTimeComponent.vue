<template>
  <clock
  style="width:150px"
  color="#4AB7BD"
  ></clock>
</template>

<script>
  import Clock from 'vue-clock2';
  export default {
    components: { Clock },
    data () {
      return {
          time: '10:40'
      }
    }
  }
</script>
