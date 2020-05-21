/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform'; //importing V-form validation
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));

import Multiselect from 'vue-multiselect';
Vue.component('Multiselect', require('vue-multiselect'));
window.Multiselect = Multiselect;

//Using Sweet alerts and components globally
import swal from 'sweetalert2'
window.swal = swal;

//******* Toast: *********
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
})
window.toast = toast; //adding to window

/***************************************************************/
window.Fire =  new Vue(); //using global comunication

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
**/


// Project component
Vue.component('projects', require('./components/ProjectComponent.vue').default);
/*
* All Components related to users
*/
Vue.component('users', require('./components/UserComponent.vue').default);
Vue.component('usersSystem', require('./components/UserSystemComponent.vue').default);
Vue.component('userAvatar', require('./components/UserProfilePhotoComponent.vue').default);
Vue.component('userNotificator', require('./components/UserNotificationsComponent.vue').default);
Vue.component('userInboxNotificator', require('./components/UserNotificationInboxComponent.vue').default);
Vue.component('userRoles', require('./components/catalogs/UserRolesComponent.vue').default);
Vue.component('usersRolesPicker', require('./components/UserRoleSelectorComponent.vue').default);
Vue.component('profile', require('./components/ProfileComponent.vue').default);
Vue.component('userFunctions', require('./components/users/UserFunctionsStructureComponent.vue').default);
/*
* All Components related to notifications
*/
Vue.component('notificatorExample', require('./components/UserNotificatorComponent.vue').default);
Vue.component('notificatorGoalsCheking', require('./components/UserNotificatorGoalsCheckingComponent.vue').default);
Vue.component('notificatorProjectStructure', require('./components/GoalsCheckingManagerComponent.vue').default);
Vue.component('notificatorTask', require('./components/TaskNotifierComponent.vue').default);

/*
*Components realted to Navigation headers
*/
Vue.component('projectNavHeader', require('./components/navheaders/ProjectNavHeaderComponent.vue').default);

Vue.component('catalogs', require('./components/catalogs/CatalogsComponent.vue').default);
Vue.component('macroprocessCatalogs', require('./components/catalogs/MacroprocessComponent.vue').default);
Vue.component('tasksCatalogs', require('./components/catalogs/TasksComponent.vue').default);



Vue.component('parameters', require('./components/ParametersComponent.vue').default);
Vue.component('subparameters', require('./components/SubParametersComponent.vue').default);
Vue.component('questions', require('./components/QuestionComponent.vue').default);
Vue.component('variables', require('./components/VariableComponent.vue').default);
Vue.component('variablesAjusteTiempos', require('./components/VariableTEComponent.vue').default);

Vue.component('subprocesos', require('./components/SubprocessComponent.vue').default);
Vue.component('procesos', require('./components/ProcessComponent.vue').default);
Vue.component('macroprocesos', require('./components/MacroprocessComponent.vue').default);
Vue.component('parameterstemplates', require('./components/templates/TemplatesParametersComponent.vue').default);
Vue.component('calendar', require('./components/calendar/CalendarComponent.vue').default);
Vue.component('TreeMenu', require('./components/treeComponent/VTreeViewMainComponent.vue').default);

Vue.component('projectStructure', require('./components/ProjectStructureComponent.vue').default);
Vue.component('help', require('./components/HelpComponent.vue').default);
Vue.component('tasks', require('./components/TaskManagerComponent.vue').default);
Vue.component('tasksElements', require('./components/TaskElementsManagerComponent.vue').default);
Vue.component('tasksUnit', require('./components/TaskUnitElementComponent.vue').default);

/*Reports*/
Vue.component('goalStatus', require('./components/reports/ReportsGoalsStatus.vue').default);
Vue.component('taskStatus', require('./components/reports/ReportsTasksStatus.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const app = new Vue({
    el: '#app',
    data:{
      search:''
    },
    methods:{
      searchit: _.debounce(() => {
            Fire.$emit('searching');
        },900),
    }
});
