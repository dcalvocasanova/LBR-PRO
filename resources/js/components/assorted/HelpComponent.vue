<template>

        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Buttons</h1>

          <div class="row">

            <div class="col-lg-6">

              <!-- Circle Buttons -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Mostrar la ayuda</h6>
                </div>
                <div class="card-body">
                  <p>Use Esto es un simple ejemplo de cómo se propone usar la herramienta para generar ayuda</p>
                  <!-- Circle Buttons (Default) -->
                  <div class="mb-2">
                    <code>Ver ayuda en una imagen</code>
                  </div>

                  Aquí se está hablando de un tema que se quiere agregar una explicación
                  <span @click="ayudaImagen()" class="btn btn-primary btn-circle btn-sm">
                    <i class="fa fa-question-circle"></i>
                  </span>
                </div>
              </div>

              <!-- Brand Buttons -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Ahora ver un vídeo</h6>
                </div>
                <div class="card-body">
                  <code>de youtube</code>
                  <span @click="ayudaVideo()" class="btn btn-primary btn-circle btn-sm">
                    <i class="fa fa-question-circle"></i>
                  </span>

                </div>
              </div>

            </div>

            <div class="col-lg-6">

              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Se pueden agregar más cosas</h6>
                </div>
                <div class="card-body">
                  <p>Puede funcionar con muchas otras</p>
                  <span @click="ayudaTexto()" class="btn btn-primary btn-circle btn-sm">
                    <i class="fa fa-question-circle"></i>
                  </span>

                </div>
              </div>
            </div>
          </div>
          <br>
        </div>
</template>
<script>
  export default {
    data () {
      return {
        paragraphs: [true],
        timer: null
      }
    },
    methods: {
      ayudaImagen(){
        swal.fire({
        title: '<strong>Imagen <u>ejemplo</u></strong>',
        type: 'info',
        html:
          '<br><br>' +
          '<img src="https://www.lolup.es/wp-content/uploads/2014/10/como-crear-una-infografia.jpg" alt="info" height="320" width="120">',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText:
          '<i class="fa fa-thumbs-up"></i> Genial!',
        confirmButtonAriaLabel: 'Thumbs up',
        cancelButtonText:
          '<i class="fa fa-thumbs-down"></i>',
        cancelButtonAriaLabel: 'Thumbs down'
        })
      },
      ayudaVideo(){
        swal.fire({
        title: '<strong>Vídeo <u>ejemplo</u></strong>',
        type: 'info',
        html:
          '<br><br>' +
          '<iframe width="360" height="315" src="https://www.youtube.com/embed/1mgRyIdH0Ws" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText:
          '<i class="fa fa-thumbs-up"></i> Genial!',
        confirmButtonAriaLabel: 'Thumbs up',
        cancelButtonText:
          '<i class="fa fa-thumbs-down"></i>',
        cancelButtonAriaLabel: 'Thumbs down'
        })
      },
      ayudaTexto(){
        swal.fire({
        html:
          '<br><br>' +
          '<img src="https://media.giphy.com/media/Xev2JdopBxGj1LuGvt/giphy.gif" alt="info" height="120" width="120">'+
          '<br><br>' +
          ' Oir un potcasts'+
          '<iframe width="238" height="48" frameborder="0" allowfullscreen="" scrolling="no" src="https://www.ivoox.com/player_ek_43296291_2_1.html?data=lZifm5uWfZKhhpywj5qdaZS1lZWah5yncZKhhpywj5aUe46ZmKiak5mRaZi3jqjc0MjNqdPo0JDdw9fFb6Xj1JCww8mJh5SZopbjx9fJt4yZk5230dfLqYy71s7bx8aJdpqfhpywjavNp8Tdhqigh6eXso6ZmKiatsrWttDmjN6YsMbIpYzBhqigh6aVt46ZmKiakg..&"></iframe>'+
          '<br><br>' +
          ' O usar este reproductor'+
          '<iframe width="200" height="150" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/96722464&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>'+
          '<br><br>' +
          ' Finalmente ir a este sitio: <a href="http://www.procame.una.ac.cr/" target="_blank">PROCAME</a> ',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText:
          '<i class="fa fa-thumbs-up"></i> Genial!',
        confirmButtonAriaLabel: 'Thumbs up',
        cancelButtonText:
          '<i class="fa fa-thumbs-down"></i>',
        cancelButtonAriaLabel: 'Thumbs down'
        })
      }
    }
  }
</script>
<style>

</style>
