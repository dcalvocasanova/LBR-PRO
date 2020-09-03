<template>
  <div class="container-elements mp-1 mp-1">
    <div v-for ="category in template" :key="category[0].id" >

      <div class="accordion" id="accordionExample">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">

              <button class="btn btn-link" type="button" data-toggle="collapse" :data-target="'#collapse'+category[0].id" aria-controls="collapseOne">
                {{category[0].category}}
                <slot name="header"></slot>
              </button>
            </h2>
          </div>
          <div :id="'collapse'+category[0].id" class="collapse"  aria-labelledby="headingOne" data-parent="#accordionExample">
		    <div v-for="c in category" :key="c.id" >

				<phyco-measure-unit
					:category="c"		
				>
				</phyco-measure-unit>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
 export default {
  props: {
    template: Array
  },
  created(){
  }
}
</script>
