<template>
    <div class="container container-project">
        <div class="row">
            <div class="col-md-6">
                <h2>Lista de tareas</h2>
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">logo</th>
                                <th scope="col">Detalles</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="project in arrayProjects" :key="project.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                <td v-text="project.name"></td>
                                <td v-text="project.logo_project"></td>
                                <td v-text="project.description"></td>
                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                    <button class="btn" @click="loadFieldsUpdate(project)">Modificar</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn" @click="deleteProject(project)">Borrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="col-md-6">
                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Nombre</label>
                    <input v-model="name" type="text" class="form-control">

                    <label>Descripción</label>
                    <input v-model="description" type="text" class="form-control">

                    <label>Logos</label>
                    <input v-model="logo_project" type="text" class="form-control">
                    <label>Logos</label>
                    <input v-model="logo_sponsor" type="text" class="form-control">
                    <label>Logos</label>
                    <input v-model="logo_auxiliar" type="text" class="form-control">
                </div>
                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveProjects()" class="btn btn-success">Añadir</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateProjects()" class="btn btn-warning">Actualizar</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                id:"",//Project ID
                name:"", //Project name
                logo_project:"", //Project's logo
                logo_sponsor:"", //Sponsor's logo
                logo_auxiliar:"", //Auxiliar's logo
                description:"", // description
                update:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
                arrayProjects:[], //BD content
            }
        },
        methods:{
            getProjects(){
                let me =this;
                axios.get('/proyectos').then(function (response) {
                    me.arrayProjects = response.data; //get all projects
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            saveProjects(){
                let me =this;
                axios.post('/proyectos/guardar',{
                    'name':this.name,
                    'logo_project':this.logo_project,
                    'logo_sponsor':this.logo_sponsor,
                    'logo_auxiliar':this.logo_auxiliar,
                    'description':this.description,

                }).then(function (response) {
                    me.getProjects();// show all projetcs
                    me.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            updateProjects(){
                let me = this;
                axios.put('/proyectos/actualizar',{
                    'id':this.update,
                    'name':this.name,
                    'logo_project':this.logo_project,
                    'logo_sponsor':this.logo_sponsor,
                    'logo_auxiliar':this.logo_auxiliar,
                    'description':this.description,
                }).then(function (response) {
                   me.getProjects();
                   me.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){
                this.update = data.id
                let me =this;
                let url = '/tareas/buscar?id='+this.update;
                axios.get(url).then(function (response) {
                    me.name= response.data.name;
                    me.logo_project= response.data.logo_project;
                    me.logo_sponsor= response.data.logo_sponsor;
                    me.logo_auxiliar= response.data.logo_auxiliar;
                    me.description= response.data.description;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            deleteProject(data){
                let me =this;
                let project_id = data.id
                if (confirm('¿Seguro que deseas borrar este Proyecto?')) {
                    axios.delete('/proyectos/borrar/'+project_id
                    ).then(function (response) {
                        me.getProjects();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            clearFields(){
                this.name = "";
                this.id="";
                this.logo_project="";
                this.logo_sponsor="";
                this.logo_auxiliar="";
                this.description= "";
                this.update= 0;
            }
        },
        mounted() {
           this.getProjects();
        }
    }
</script>
