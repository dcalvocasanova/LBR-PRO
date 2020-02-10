<template>
  <div class="container container-project">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Gestor de roles y permisos de usuario</h4>
            <button class="btn btn-primary"
              data-toggle="modal"
              data-target="#addRoles">
              <i class="fa fa-plus-circle">
                Agregar nuevo tipo de usuario
              </i>
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <tr>
                    <th> Nombre </th>
                    <th> Acciones </th>
                  </tr>
                </thead>
                <tbody>
                    <tr  v-for="role in Roles.data" :key="role.id">
                      <td v-text="role.name"></td>
                      <td>
                        <button class="btn btn-info" @click="loadFieldsUpdate(role)"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger" @click="deleteRole(role)"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-primary"
                          @click="getRolePermissions(role)"
                          data-toggle="modal"
                          data-target="#setPermissions">
                          <i class="fas fa-swatchbook">
                            Permisos de acceso
                          </i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="Roles" @pagination-change-page="loadRoles"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addRoles" tabindex="-1" role="dialog" aria-labelledby="ModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ModalLabel">Agrega nuevo rol de usuario</h5>
            <button type="button"  @click="salir"  class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input v-model="form.name" type="text" class="form-control":class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                  </div>
                <div class="row">
                  <div class="container-buttons">
                    <button v-if="updateCatalogo == 0" @click="saveRole()" class="btn btn-success">Añadir</button>
                    <button v-if="updateCatalogo != 0" @click="updateRole()" class="btn btn-info">Actualizar</button>
                    <button v-if="updateCatalogo != 0" @click="clearFields()" class="btn btn-secondary">Atrás</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="setPermissions" tabindex="-1" role="dialog" aria-labelledby="ModalLabel-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="ModalLabel">Gestión de permisos de acceso según rol de usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> Permisos a otorgar</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <tr>
                          <th> Permiso </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="p in permissions" :key="p.code">
                          <td><input v-model="permissonsToAssign" type="checkbox" :name=p.code :value=p.code> {{p.name}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <button @click="savePermissions()" class="btn btn-success">Guardar permisos</button>
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
        form: new Form ({
          id:"",//User ID
          name:""
        }),
        title:"Registrar nuevo elemento", //title to show
        type:"GENDER", //indicates which catalog is shown
        roleToUpdate:0,
        updateCatalogo:0, // checks if it is an undate action or adding a new one=> 0:add !=0 :update
        Roles:{}, //DB content
        permissonsToAssign: [],
        all:[],
        permissions: [
          {id:'1', name: 'Crear usuarios', code: 'CR_users' },
          {id:'2', name: 'Eliminar y actualizar usuarios', code: 'CRUD_users' },
          {id:'3', name: 'Crear proyectos', code: 'CR_projects' },
          {id:'4', name: 'Eliminar y actualizar proyectos', code: 'CRUD_projects' },
          {id:'5', name: 'Gestionar parámetros', code: 'CRUD_parameters' },
          {id:'6', name: 'Gestionar macroprocesos', code: 'CRUD_macroprocess' },
          {id:'7', name: 'Gestionar tareas', code: 'CRUD_tasks' },
          {id:'8', name: 'Gestionar catálogos', code: 'CRUD_catalogs' },
          {id:'9', name: 'Gestionar reporte', code: 'R_reports' },
          {id:'10', name: 'Usuario del sistema', code: 'simple_user' }
        ]
      }
    },
    methods:{
      loadRoles(page= 1) {
        let me = this
        axios.get('/catalogo/roles?page='+ page)
        .then(response => {
            me.Roles = response; //get all user's roles
        });
      },
      saveRole(){
          let me =this;
          me.form.type = 'ROLE';
          me.form.post('/catalogo/guardar-rol')
          .then(function (response) {
              me.clearFields();
              me.loadRoles();
              swal.fire(
                'Rol de usuario registrado existosamente',
                'Recuerde que debe agregarle permisos',
                'success'
              )
          })
          .catch(function (error) {
              console.log(error);
          });

      },
      updateRole(){
          let me =this;
          me.form.type = 'ROLE';
          me.form.put('/catalogo/actualizar-rol')
          .then(function (response) {
             toast.fire({
              type: 'success',
              title: 'Rol actualizado con éxito'
             });
             this.LoadRoles(this.type);
             me.clearFields();
          })
          .catch(function (error) {
              console.log(error);
          });
          this.clearFields();
      },
      loadFieldsUpdate(role){
        this.title= "Actualizar role";
        this.form.name = role.name;
        this.form.id = role.id;
        this.updateCatalogo= role.id;
        $('#addRoles').modal('toggle');
      },
      clearFields(){
          let me =this;
          me.salir()
          $('#addRoles').modal('toggle');
          me.loadRoles();
      },
      salir(){
        let me =this;
        me.title= "Registrar nuevo elemento";
        me.updateCatalogo= 0;
        me.form.reset();
      },
      savePermissions(){
        let me =this;
        axios.post('/catalogo/guardar-permisos/'+me.roleToUpdate, {
          roles: me.permissonsToAssign
        })
        .then(function (response) {
          $('#setPermissions').modal('toggle');
          toast.fire({
           type: 'success',
           title: 'Permisos actualizados con éxito'
          });
        })
        .catch(function (error) {
          console.log(error);
        });
      },
      getRolePermissions(role){
        let me =this;
        me.roleToUpdate = role.id;
        axios.get('/catalogo/permisos-del-rol/'+role.id)
        .then(function (response) {
          me.permissonsToAssign=response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      deleteRole(role){
          let me =this;
          let catalog_id = role.id
          swal.fire({
            title: 'Eliminar elemento',
            text: "Esta acción no se puede revertir, está a punto de eliminar un rol de usuario",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#114e7e',
            cancelButtonColor: '#20c9a6',
            confirmButtonText: '¡Sí, eliminarlo!'
          })
          .then((result) => {
            if (result.value) {
              axios.delete('/catalogo/borrar-rol/'+role.id)
              .then(function (response) {
                this.loadRoles();
                swal.fire(
                  'Eliminado',
                  'El elemento fue eliminado',
                  'success'
                )
              })
              .catch(function (error) {
                  console.log(error);
              });
              this.loadRoles();
            }
          })
      },
    },
    created(){
      Fire.$on('searching',() => {
          toast.fire({
            type: 'WARNING',
            title: 'Las búsquedas se encuentran deshabilitadas en esta opción'
          });
        })
    },
    mounted() {
       this.loadRoles();
    }
  }
</script>
