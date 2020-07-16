<template>
  <div class="col-12 form-inline mr-auto ml-md-3">
    <div class="col-12">
        <select v-model="form.id" class="form-control" @change="selectedProject()">
          <option v-for="p in Projects" :value="p.id">{{ p.name }}</option>
        </select>
    </div>
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
