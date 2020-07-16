<template>
  <div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1>Perfil del usuario</h1></div>
      <br><br>
    </div>
    <div class="row">
  		<div class="col-sm-3">
        <div class="text-center">
          <img :src="AvatarMainPage" class="avatar img-circle img-thumbnail" :alt="user.name">
          <br><br><br>
          <div class="form-group">
            <label for="logo_organization" class="col-sm-8 control-label file-uploader">  <i class="fas fa-cloud-upload-alt"> Cambiar imagen <span v-html="avatarLoaded"></span></i> </label>
            <div class="col-sm-12">
                <input type="file" @change="changeAvatar" name="logo_organization" id="logo_organization" class="form-input" style='display: none;'>
            </div>
          </div>
          <div class="form-group" v-if="showSaveButton">
            <div class="col-sm-12">
              <button @click="uploadAvatar" type="button" class="btn btn-primary"> Guardar ávatar</button>
            </div>
          </div>
        </div>
        <br><br>
      </div>
    	<div class="col-sm-9">
        <div class="card-body">
          <div class="row">
            <div class="col-md-5">
              <div class="card mb-3 py-0 border-bottom-danger">
                <div class="card-body">
                  Nombre : {{user.name}}
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="card mb-3 py-0 border-bottom-danger">
                <div class="card-body">
                  Identificación : {{user.identification}}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card mb-3 py-0 border-bottom-danger">
                <div class="card-body">
                  Puesto : {{user.job}}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-3 py-0 border-bottom-danger">
                <div class="card-body">
                  Cargo : {{user.position}}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-3 py-0 border-bottom-danger">
                <div class="card-body">
                  Jornada : {{user.workday}}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="center-block">
                <button class="btn btn-primary"
                  data-toggle="modal"
                  data-target="#PasswordManager">
                    <i class="fa fa-unlock-alt"> Cambiar contraseña de ingreso</i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="PasswordManager" tabindex="-2" role="dialog" aria-labelledby="PasswordManager-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="PasswordManager">Cambiar contraseña de ingreso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">Nueva contraseña</label>
                      <input  v-model="newPassword" type="text" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="container-buttons">
                    <button @click="changePassword()" class="btn btn-success">Cambiar</button>
                    <button @click="salir()"class="btn btn-secondary">Atrás</button>
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
export default {
  data() {
    return {
      user:{},
      avatar:'',
      showSaveButton:false,
      avatarLoaded:"",
      newPassword:""
    }
  },
  methods: {
    changeAvatar(f){
      this.showSaveButton=true
      let file = f.target.files[0];
      let reader = new FileReader();
      if (this.validateFile(file)){
        this.avatarLoaded ='<i class="far fa-check-circle"></i> ';
        reader.onloadend = (file) => {
            this.avatar = reader.result;
        }
        reader.readAsDataURL(file);
      }
    },
    validateFile(file){
      let limit = 1024*1024*2;
      if(file['size'] > limit){
          return false;
      }
      return true;
    },
    uploadAvatar(){
      let me =this
      me.showSaveButton=false
      axios.put('/usuarios/avatar-change', {
        id: this.user.id,
        avatar: this.avatar
      })
      .then(function (response) {
        Fire.$emit('updateAvatar')
        me.getCurrentUser()
      })
    },
    changePassword(){
      if(this.newPassword.trim() != ""){
        axios.put('/usuarios/password-change', {
          id: this.user.id,
          password: this.newPassword
        })
        .then(function (response) {
          toast.fire({
           type: 'success',
           title: 'Contraseña actualizada con éxito'
          });
          this.salir();
        })
        .catch(function (error) {
          console.log(error);
        });
        this.salir();
      }else{
        swal.fire(
          'La contraseña','No es válida','error'
        )
      }
    },
    salir(){
      $('#PasswordManager').modal('toggle');
      this.newPassword = ""
      this.avatar=""
    },
    getCurrentUser(){
      let me =this;
      axios.get('/usuario')
      .then(response => {
          me.user = response.data; //get current user
      });
    }
  },
  mounted() {
    this.getCurrentUser();
  },
  computed: {
    AvatarMainPage: function () {
      return "img/profile-usr/"+ this.user.avatar;
    }
  }
}
</script>
