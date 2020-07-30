<template>
  <div class="w-100 p-3 ">
    <select v-model="form.id" class="form-control" @change="selectedProject()">
      <option v-for="p in Projects" :value="p.id">{{ p.name }}</option>
    </select>
  </div>
</template>

<script>
export default {
  data(){
    return{
      form: new Form ({
        id:""
      }),
      Projects:{}
    }
  },
  methods:{
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
          me.form.id = response.data.id;
      });
    },
    selectedProject(project){
      let me =this;
      me.form.post('/proyecto/establecer');
    }
  },
  created(){
    this.getProjects()
    this.getCurrentProject()
  }
}
</script>
