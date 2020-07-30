<template>
  <div class="container bootstrap">
    <div class="overlay"></div>
    <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="mp4/bg.mp4" type="video/mp4">
    </video>
    <div class="masthead">
    <div class="masthead-bg"></div>
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-12 my-auto">
          <div class="masthead-content text-white py-5 py-md-0">
            <h1 class="mb-3">Hola {{user.name }}</h1>
            <p class="mb-5">Antes de comenzar es necesario aceptar términos y condiciones del uso de la herramienta</p>
            <div class="input-group input-group-newsletter col-12 my-auto">
              <div class="input-group-append" v-if="show">
                <button class="btn btn-secondary" @click="aceptance" type="button" id="submit-button">Acepto términos y condiciones</button>
              </div>
            </div>
          </div>
          <embed v-if="show"
          :src="agrement"
          class="agreement"
          type="application/pdf"
          width="100%"
          height="400px"
          />
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
      agrement:{},
      show: false,
    }
  },
  methods: {
    getCurrentProjectTerms(){
      let me =this;
      axios.get('/proyecto/terms')
      .then(response => {
        if(response.data.id > 0){
            this.show = true
            me.agrement = response.data.terms
        }
      });
    },
    aceptance(){
      axios.get('/terminos/aceptar')
      .then(response => {
        if(response.data.id > 0){
          location.reload()
        }
      });
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
    this.getCurrentProjectTerms();
  }
}
</script>

<style scoped>

html {
  height: 100%;
}

body {
  height: 100%;
  min-height: 35rem;
  position: relative;
  font-family: 'Source Sans Pro';
  font-weight: 300;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: 'Merriweather';
  font-weight: 700;
}

video {
  position: fixed;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 300%;
  width: auto;
  height: auto;
  transform: translateX(-50%) translateY(-50%);
  z-index: 0;
}

.agreement {
  /*position: absolute;*/
  margin-top: 20px;
  top: 90%;
  left: 10%;
  min-width: 100%;
  min-height: 300px;
  width: auto;
  height: auto;
}


@media (pointer: coarse) and (hover: none) {
  body {
    background: #002E66 no-repeat center center scroll;
    background-size: cover;
  }
  body video {
    display: none;
  }
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: #cd9557;
  opacity: 0.7;
  z-index: 1;
}

.masthead {
  position: relative;
  overflow: hidden;
  padding-bottom: 3rem;
  z-index: 2;
}

.masthead .masthead-bg {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  width: 100%;
  min-height: 35rem;
  height: 100%;
  background-color: rgba(0, 46, 102, 0.8);
  transform: skewY(4deg);
  transform-origin: bottom right;
}

.masthead .masthead-content h1 {
  font-size: 2.5rem;
}

.masthead .masthead-content p {
  font-size: 1.2rem;
}

.masthead .masthead-content p strong {
  font-weight: 700;
}

.masthead .masthead-content .input-group-newsletter input {
  height: auto;
  font-size: 1rem;
  padding: 1rem;
}

.masthead .masthead-content .input-group-newsletter button {
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 1rem;
}

@media (min-width: 768px) {
  .masthead {
    height: 100%;
    min-height: 0;
    width: 40.5rem;
    padding-bottom: 0;
  }
  .masthead .masthead-bg {
    min-height: 0;
    transform: skewX(-8deg);
    transform-origin: top right;
  }
  .masthead .masthead-content {
    padding-left: 3rem;
    padding-right: 10rem;
  }
  .masthead .masthead-content h1 {
    font-size: 3.5rem;
  }
  .masthead .masthead-content p {
    font-size: 1.3rem;
  }
}

</style>
