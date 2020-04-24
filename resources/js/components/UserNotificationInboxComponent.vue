<template>
  <div class="row">
  	<div class="col-lg-4 col-md-5">
      <div class="col-12">
        <button type="button" class="btn btn-primary ">
          <h4>Notificaciones <span class="badge badge-light">{{ notifications.length }}</span> </h4>
        </button>
        <br><br>
      </div>
      <div class="ibox" id="inbox-notification-container">
        <div class="inbox-notification clf">
  				<table class="table table-hover table-inbox" id="table-inbox">
  					<tbody class="rowlinkx" data-link="row"
              v-for="notification in notifications" :key="notification.id">
  						<tr :class="isUnread(notification)" @click="openNotification(notification)">
  							<td class="mail-message">{{ notification.title }}</td>
  							<td class="hidden-xs"></td>
  						</tr>
  					</tbody>
  				</table>
  			</div>
  		</div>
  	</div>
  	<div v-if="showInboxNotification" class="col-lg-8 col-md-7">
      <div class="ibox" id="mailbox-container">
        <div class="mailbox-header d-flex justify-content-between" style="border-bottom: 1px solid #e8e8e8;">
          <div>
            <h5 class="inbox-title">{{ notificationToRead.tittle}}</h5>
            <div class="m-t-5 font-13">
                <span class="font-strong">{{ notificationToRead.title}}</span>
            </div>
            <div class="p-r-10 font-13">
              <time-ago :datetime="notificationToRead.created_at" refresh locale="es" long></time-ago>
            </div>
          </div>
          <div class="inbox-toolbar m-l-20" v-if="ableToCheck(notificationToRead)">
            <button class="btn btn-default btn-sm btn-outline-primary"
            @click="checkAsOK" >
              <i class="fa fa-check"> Aceptar </i>
            </button>
            <button class="btn btn-default btn-sm btn-outline-danger"
              data-toggle="modal"
              data-target="#RejectionForm">
                <i class="fa fa-times warning"> Rechazar </i>
            </button>
          </div>
          <div class="inbox-toolbar m-l-20" v-if="!ableToCheck(notificationToRead)">
            <h3>
              <span class="badge badge-primary">{{ getStatus(notificationToRead.status) }} </span>
            </h3>
          </div>
        </div>
        <div class="mailbox-body">
            <p v-html="notificationToRead.body"></p>
        </div>
      </div>
  	</div>
    <div class="modal fade" id="RejectionForm" tabindex="-1" role="dialog" aria labelledby="RejectionForm-lg" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="RejectionForm"> Razones del rechazo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="card">
                  <div class="card-body">
                    <div class="col-12">
                      <textarea v-model="form.reasons" name="reasons" style="width:100%;height:200px;"/>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button @click="reject()" class="btn btn-info">Confirmar rechazo </button>
                    <button @click="exit()" class="btn btn-secondary">cancelar</button>
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
  import TimeAgo from "vue2-timeago";
  export default {
    components: {
      TimeAgo
    },
    props: {
      user: Object
    },
    data(){
      return{
        form: new Form ({
          id:0,
          reasons:""
        }),
        dataToSend:{},
        notifications:{},
        notificationToRead:{},
        showInboxNotification: false
      }
    },
    methods:{
      getUserNotifications(){
        let me =this;
        axios.get('/usuario/notificaciones')
        .then(response => {
            me.notifications = response.data; //get current user
        });
      },
      checkAsOK(){
        let me = this
        me.saveStatus()
      },
      ableToCheck(notification){
        if(notification.status !== 'Pending'){
          return false;
        }
        return true;
      },
      saveStatus(){
        this.form.put('/notificaciones/aceptar')
        .then(function (response) {
           toast.fire({
            type: 'success',
            title: 'Notificación confirmada'
           });
        })
        .catch(function (error) {
            console.log(error);
        });
        this.showInboxNotification = false
        this.getUserNotifications()
      },
      openNotification(notification){
        let me = this;
        me.notificationToRead = notification
        me.form.id=notification.id
        me.dataToSend= notification.data
        me.showInboxNotification = true;
      },
      getStatus(status){
        console.log(status)
        if (status === "Acepted"){return "Notificación aceptada"}
        if (status === "Rejected"){return "Notificación rechazada"}
        if (status === "Correcting"){return "Notificación proceso de subsane"}
        if (status === "Corrected"){return"Notificación ya subsanada"}
      },
      reject(){
        if(this.form.reasons.trim() === ""){
          swal.fire(
            'Información','Es necesario completar la razón del rechazo','warning'
          )
        }else{
          this.form.put('/notificaciones/rechazar')
          .then(function (response) {
             toast.fire({
              type: 'success',
              title: 'Notificación rechazada'
             });
          })
          .catch(function (error) {
              console.log(error);
          });
          this.showInboxNotification = false
          $('#RejectionForm').modal('toggle')
          this.getUserNotifications()
        }
      },
      exit(){
        $('#RejectionForm').modal('toggle')
      },
      isUnread(notification){
        if (notification.status === 'Pending'){
          return "unread"
        }
        return "readed"
      }
    },
    mounted() {
      this.getUserNotifications()
    }
  }
</script>

<style>
.table-inbox tr.unread {
  font-weight: 600;
}
</style>
