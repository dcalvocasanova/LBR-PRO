<template>
  <div class="row">
    <div class="col-12">
        <h3 class="card-title mt-0">  Notificaciones ({{ notifications.length }})</h3>
    </div>
  	<div class="col-lg-4 col-md-5">
      <div class="ibox" id="inbox-notification-container">
        <div class="inbox-notification clf">
  				<table class="table table-hover table-inbox" id="table-inbox">
  					<tbody class="rowlinkx" data-link="row"
              v-for="notification in notifications" :key="notification.id">
  						<tr :class="isUnread(notification)" @click="openNotification(notification)">
  							<td class="mail-message">{{ notification.data.message }}</td>
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
                <h5 class="inbox-title">{{ notificationToRead.data.message}}</h5>
                <div class="m-t-5 font-13">
                    <span class="font-strong">{{ notificationToRead.data.sender.name}}</span>

                </div>
                <div class="p-r-10 font-13">{{notificationToRead.created_at}} </div>
            </div>
            <div class="inbox-toolbar m-l-20">
                <button class="btn btn-default btn-sm" data-action="reply" data-toggle="tooltip" data-original-title="Reply"><i class="fa fa-reply"></i></button>
            </div>
        </div>
        <div class="mailbox-body">
            <p> {{notificationToRead.data.body}}  </p>
        </div>
      </div>
  	</div>
  </div>
</template>

<script>
  export default {
    props: {
      user: Object
    },
    data(){
      return{
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
      openNotification(notification){
        let me = this;
        me.notificationToRead = notification
        me.showInboxNotification = true;
      },
      isUnread(notification){
        if (notification.read_at === null){
          return "unread"
        }
        return "readed"
      }
    },
    created(){
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
