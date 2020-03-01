<template>
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{user.name}}</span>
      <img class="img-profile rounded-circle" :src="AvatarMainPage" alt="User avatar">
    </a>
    <!-- Dropdown information-->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="/perfil-usuario">
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
        Perfil
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Salir
      </a>
    </div>
  </li>
</template>

<script>
  export default {
    data(){
      return{
        user:{}
      }
    },
    computed: {
      AvatarMainPage: function () {
        return "/img/profile-usr/"+ this.user.avatar;
      }
    },
    methods:{
      getCurrentUser(){
        let me =this;
        axios.get('/usuario')
        .then(response => {
            me.user = response.data; //get current user
        });
      }
    },
    created(){
      Fire.$on('updateAvatar',() => {
          this.getCurrentUser()
      })
    },
    mounted() {
      this.getCurrentUser()      
    }
  }
</script>
