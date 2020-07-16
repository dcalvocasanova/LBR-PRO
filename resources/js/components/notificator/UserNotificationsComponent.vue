<template>
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bell fa-fw"></i>
      <!-- Counter - Alerts -->
      <span class="badge badge-danger badge-counter">{{ notifications.length }} +</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
      <h6 class="dropdown-header">
        Centro de notificaciones
      </h6>
      <div v-for="notification in notifications" :key="notification.id">
        <a class="dropdown-item d-flex align-items-center" href="/notificaciones">
          <div class="mr-3">
            <div class="icon-circle bg-primary">
              <i class="fas fa-file-alt text-white"></i>
            </div>
          </div>
          <div>
            <div class="row">
              <div class="col-11">
                <div class="small text-gray-500">
                    <time-ago :datetime="notification.created_at" refresh locale="es" long></time-ago>
                </div>
                <span class="font-weight-bold">{{ notification.title }}</span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <a class="dropdown-item text-center small text-gray-500" href="/notificaciones">Todas las notificaciones</a>
    </div>
  </li>
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
        notifications:{}
      }
    },
    methods:{
      getUserNotifications(){
        let me =this;
        axios.get('/usuario/notificaciones-nuevas')
        .then(response => {
            me.notifications = response.data; //get current user
        });
      }
    },
    created(){
      Fire.$on('updateNotifications',() => {
          this.getUserNotifications()
      })
    },
    mounted() {
      this.getUserNotifications()
    }
  }
</script>
