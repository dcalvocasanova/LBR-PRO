<template>
  <div class="row">
    <div class="col-12">
        <h3 class="card-title mt-0"> Enviar notificación</h3>
    </div>
  	<div class="col-lg-4 col-md-5">
      <div class="ibox" id="inbox-notification-container">
        <div class="inbox-notification clf">
  				<table class="table table-hover table-inbox" id="table-inbox">
  					<tbody class="rowlinkx" data-link="row"
              v-for="user in users.data" :key="user.id">
  						<tr class="users-to-notify">
                <td><input v-model="notify" type="checkbox" :name="user.id" :value="user.id"> {{user.name}}</td>
  						</tr>
  					</tbody>
  				</table>
  			</div>
  		</div>
  	</div>
    <div class="col-lg-8 col-md-7">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Notificar</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label class="bmd-label-floating">Titulo</label>
                <input v-model="notification.msg" type="text" class="form-control":class="{ 'is-invalid': notification.errors.has('title') }">
                <has-error :form="notification" field="title"></has-error>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label class="bmd-label-floating">Detalle</label>
                <input v-model="notification.body" type="text" class="form-control":class="{ 'is-invalid': notification.errors.has('body') }">
                <has-error :form="notification" field="body"></has-error>
              </div>
            </div>
          </div>
          <div class="container-buttons">
            <button @click="sendNotification()" class="btn btn-success">Enviar</button>

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
        users:{},
        notify:[],
        notification: new Form ({
          msg:"",
          sender:"",
          usersToNotify:[],
          body:""
        }),
      }
    },
    methods:{
      getUsers(){
        let me =this
        axios.get('/usuarios')
        .then(response => {
            me.users = response.data; //get current user
        });
      },
      sendNotification(){
        let me = this
        if(me.notify.length > 0){
          me.notification.usersToNotify = me.notify
          me.notification.post('/sender')
          .then(function (response) {
            toast.fire({
             type: 'success',
             title: 'Mensaje con éxito'
            });
            me.notification.reset()
          })
          .catch(function (error) {
            console.log(error);
          });
          me.notification.reset()
          me.notify=[]
        }else{
          swal.fire(
            'Error','Debe seleccionar un usuario a notificar','error'
          )
        }

      }

    },
    mounted() {
      this.getUsers()
    }
  }
</script>
