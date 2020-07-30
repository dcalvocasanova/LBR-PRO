<template>
  <div class="container text-center">
    <div class="row">
      <div class="text-center date-body" style="width:100%">
        <label for="" class="date-title"> {{year}}</label>
        <div class="date-content">
          <p class="nomargin"><strong>{{ dayName }} </strong></p>
          <hr class="nomargin"/>
          <p class="dia"> {{ day}}</p>
          <hr class="nomargin"/>
          <p class="nomargin"><strong>{{ monthName }}</strong></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
          year: '',
          month:'',
          day:'',
          dayName:'',
          monthName:'',
          days : ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
          months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octobre", "Novimbre", "Diciembre"]
      }
    },
    methods: {
      getNow: function() {
        let today = new Date()
        this.year = today.getFullYear()
        this.month = today.getMonth()
        this.day = today.getDay()
        this.dayName = this.days[today.getDay()]
        this.monthName= this.months[today.getMonth()]
      }
    },
    created() {
      this.getNow()
    },
  }
</script>

<style scoped>

.date-body{
  background-color: #4AB7BD; padding-bottom: 5px;
}
.date-body .date-title{
  color: white;
  font-size: 25px;
}

.date-body .date-content{
  background-color: white;margin-left: 5px;margin-right: 5px;
}
.date-body .date-content p.dia{
  margin: 0; font-size: 65px; font-weight: bold;
}
.nomargin{
  margin: 0;
}

</style>
