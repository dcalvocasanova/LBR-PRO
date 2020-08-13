<template>
  <div class="container-elements mp-1 mp-1">
    <div class="row">
      <div class="col-md-6 text-center">
        <button type="button" class="btn btn-outline-info btn-lg " disabled>{{task.task}}</button>
      </div>
      <br>
      <div class="col-md-6 ">
        <div class="form-group">
          <label class="bmd-label-floating">Procedimiento</label>
          <input @click="showSave" v-model="form.procedure" type="text" class="form-control">
        </div>
      </div>
    </div>
    <div class="row" v-if="showTimeOption">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Frecuencia</label>
          <select @change="showSave" v-model="form.frecuency" class=" form-control">
            <option v-for="f in Frecuencies">{{ f.name }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Cantidad</label>
          <input @click="showSave" type="number" v-model="form.quantity"  class="form-control">
        </div>
      </div>
    </div>
    <div class="row" v-if="showTimeOption">
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo menor</label>
          <input @click="showSave" type="number" v-model="form.t_min"  class="form-control">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo normal</label>
          <input @click="showSave" type="number" v-model="form.t_avg"  class="form-control">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tiempo mayor</label>
          <input @click="showSave" type="number" v-model="form.t_max"  class="form-control">
        </div>
      </div>

    </div>
    <div class="row" v-if="showImproveOption">
      <div class="col-md-4" @click="showSave">
        <div class="form-group">
          <label class="bmd-label-floating"> </label>
          <treeselect
            :clearable="true"
            :searchable="true"
            :options="PHVA"
            :limit="8"
            :max-height="300"
            placeholder="PHVA"
            noResultsText="No existe registro"
            clearValueText="Eliminar"
            v-model="form.PHVA"
            />
        </div>
      </div>
      <div class="col-md-4" @click="showSave">
        <div class="form-group">
          <label class="bmd-label-floating"> </label>
          <treeselect
            :clearable="true"
            :searchable="true"
            :options="Skills"
            :limit="3"
            :max-height="300"
            placeholder="Competencias de trabajo"
            noResultsText="No existe registro"
            noChildrenText="Sin categorías"
            clearValueText="Eliminar"
            v-model="form.competence"
            />
        </div>
      </div>
      <div class="col-md-4" @click="showSave">
        <div class="form-group">
          <label class="bmd-label-floating"> </label>
          <treeselect
            :clearable="true"
            :searchable="true"
            :options="WorkTypes"
            :limit="3"
            :max-height="300"
            placeholder="Tipo de trabajo"
            noResultsText="No existe registro"
            noChildrenText="Sin categorías"
            clearValueText="Eliminar"
            v-model="form.laborType"
            />
        </div>
      </div>
    </div>
    <div class="row" v-if="showImproveOption">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Tipo de Esfuerzo</label>
          <select @change="showSave" v-model="form.effort" class=" form-control">
            <option v-for="s in Effort">{{ s.name }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-6" @click="showSave">
        <div class="form-group">
          <label class="bmd-label-floating"> </label>
          <treeselect
            :clearable="true"
            :searchable="true"
            :options="Risk"
            :limit="8"
            :max-height="300"
            placeholder="Riesgos de trabajo"
            noResultsText="No existe registro"
            noChildrenText="Sin categorías"
            clearValueText="Eliminar"
            v-model="form.risk"
            />
        </div>
      </div>
    </div>
    <div class="row" v-if="showImproveOption">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Valor Agregado</label>
          <table class="table table-striped">
              <thead>
                <tr>
                  <th> Aspecto </th>
                  <th> Valoración </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(a, index) in AddedValue" :key="a.id">
                  <th v-text="a.name"></th>
                  <th>
                    <input @click="showSave" type="radio" v-model="addedValueArray[index]" value="1"> 1
                    <input @click="showSave" type="radio" v-model="addedValueArray[index]" value="2"> 2
                    <input @click="showSave" type="radio" v-model="addedValueArray[index]" value="3"> 3
                    <input @click="showSave" type="radio" v-model="addedValueArray[index]" value="4"> 4
                    <input @click="showSave" type="radio" v-model="addedValueArray[index]" value="5"> 5
                  </th>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Correlación</label>
          <table class="table table-striped">
              <thead>
                <tr>
                  <th> Aspecto </th>
                  <th> Valoración (marcar para sí, dejar en blanco para no)  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="a in Correlation" :key="a.id">
                  <th v-text="a.name"></th>
                  <th>
                    <input @click="showSave" v-model="correlationArray" type="checkbox":value="a.id">
                  </th>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>
    <br>
    <div class="row mb-2">
      <div class="col-12 text-center">
        <button v-if="showSaveButton" @click="saveTask()" class="btn btn-success"> Guardar</button>
      </div>
    </div>
  </div>
</template>

<script>
 import Treeselect from '@riophae/vue-treeselect'
 import '@riophae/vue-treeselect/dist/vue-treeselect.css'
 export default {
  name: 'tasks-unit',
  components: { Treeselect },
  props: {
    task: Object,
    showTimeOption: Boolean,
    showImproveOption: Boolean,
    WorkTypes: Array,
    PHVA: Array,
    Frecuencies: Array,
    Correlation: Array,
    AddedValue: Array,
    Risk: Array,
    Effort: Array,
    Skills: Array
  },
  data(){
    return{
      form: new Form ({
        id:"",
        task:"",
        allocator:"",
        project_id:"",
        procedure:"",
        PHVA:"",
        frecuency:"",
        t_min:"",
        t_avg:"",
        t_max:"",
        quantity:"",
        laborType:"",
        competence:"",
        effort:"",
        risk:"",
        addedValue:[],
        correlation:[]
      }),
      showSaveButton:false,
      details:"",
      correlationArray: [],
      addedValueArray: []
    }
  },
  methods:{
    showSave(){
      this.showSaveButton=true
    },
    saveTask(){
      this.showSaveButton=false
      this.updateTask()
    },
    updateTask(){
      let me = this
      me.form.id= me.task.id
      me.form.task= me.task.task
      me.form.allocator= me.task.allocator
      me.form.project_id= me.task.project_id
      me.form.addedValue=me.addedValueArray
      me.form.correlation=me.correlationArray
      me.form.put('/tareas/actualizar')
      .then(function (response) {
         toast.fire({
          type: 'success',
          title: 'Elementos de la tarea agregados con éxito'
         });
      })
    },
  },
  created(){
    let me = this
    this.form.fill(this.task)
    if(me.task.addedValue !== null){
        me.addedValueArray=me.task.addedValue
    }
    if(me.task.correlation !== null){
        me.correlationArray=me.task.correlation
    }
  }
}
</script>
