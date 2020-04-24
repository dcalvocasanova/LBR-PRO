<template>
  <div class="row">
    <div class="col-12">
        <h3 class="card-title mt-0"> Enviar notificación para aprobación de objetivo</h3>
    </div>
  	<div class="col-lg-4 col-md-5">
      <div class="ibox" id="inbox-notification-container">
        <div class="inbox-notification clf">
  				<table class="table table-hover table-inbox" id="table-inbox">
            <thead>
              <tr>
                <th> Usuarios registrados en el nivel de estructura</th>
              </tr>
            </thead>
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
                <p> {{notification.title}}</p>

              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label class="bmd-label-floating">Detalle</label>
                <div id="notificationDetails" v-html="getGoalInformation">
                </div>
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
    props:{
        Item: Object,
        Project: Object,
    },
    data(){
      return{
        users:{},
        notify:[],
        notification: new Form ({
          title:"Aprobación de objetivos",
          body:"",
          project_id: 0,
          relatedToLevel:'',
          usersToNotify:[]
        }),
      }
    },
    computed: {
      getGoalInformation: function () {
        let msg = "En el proyecto: "+ this.Project.name +" en el nivel "+ this.Item.name +", existe "+ this.Item.numGoals+" objetivos que deben ser aprobados <br>"
        msg +='<br>'
        for(let goal in this.Item.goals){
          msg += "- código: "+ this.Item.goals[goal].code +" objetivo: "+this.Item.goals[goal].name+"<br>"
        }
        return msg
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
          me.notification.body = me.getGoalInformation
          me.notification.relatedToLevel = this.Item.name
          me.notification.project_id = me.Project.id
          me.notification.post('/sender')
          .then(function (response) {
            toast.fire({
             type: 'success',
             title: 'Notificación enviada con éxito'
            });
          })
          .catch(function (error) {
            console.log(error);
          });
          me.$emit('close-modal')
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
