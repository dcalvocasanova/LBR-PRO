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

/*---------------------------------------------------------
| Components by functionality
------------------------------------------------------------*/
//DASHBOARD
Vue.component('projectTime', require('./components/dashboard/ProjectTimeComponent.vue').default);
Vue.component('projectDate', require('./components/dashboard/ProjectTimeDateComponent.vue').default);

//Catalogs
Vue.component('catalogNavHeader', require('./components/navheaders/CatalogsNavHeaderComponent.vue').default);
Vue.component('catalogs', require('./components/catalog/CatalogsComponent.vue').default);
Vue.component('macroprocessCatalogs', require('./components/catalog/MacroprocessComponent.vue').default);
Vue.component('tasksCatalogs', require('./components/catalog/TasksComponent.vue').default);
Vue.component('userRoles', require('./components/catalog/UserRolesComponent.vue').default);

//Users
Vue.component('users', require('./components/user/UserComponent.vue').default);
Vue.component('usersSystem', require('./components/user/UserSystemComponent.vue').default);
Vue.component('userAvatar', require('./components/user/UserProfilePhotoComponent.vue').default);
Vue.component('userInboxNotificator', require('./components/user/UserNotificationInboxComponent.vue').default);
Vue.component('usersRolesPicker', require('./components/user/UserRoleSelectorComponent.vue').default);
Vue.component('profile', require('./components/user/ProfileComponent.vue').default);
Vue.component('userFunctions', require('./components/user/UserFunctionsStructureComponent.vue').default);
Vue.component('userTerms', require('./components/user/UserTermsComponent.vue').default);

//notifications
Vue.component('notificatorGoalsCheking', require('./components/notificator/NotificatorGoalsCheckingComponent.vue').default);
Vue.component('notificatorProjectStructure', require('./components/notificator/GoalsCheckingManagerComponent.vue').default);
Vue.component('notificatorTask', require('./components/notificator/TaskNotifierComponent.vue').default);
Vue.component('userNotificator', require('./components/notificator/UserNotificationsComponent.vue').default);

//Projects
Vue.component('projectNavHeader', require('./components/navheaders/ProjectNavHeaderComponent.vue').default);
Vue.component('projectPicker', require('./components/dashboard/ProjectPickerComponent.vue').default);
Vue.component('TreeMenu', require('./components/treeComponent/VTreeViewMainComponent.vue').default);
/*******/
Vue.component('projects', require('./components/project/ProjectComponent.vue').default);
Vue.component('projectStructure', require('./components/project/ProjectStructureComponent.vue').default);

//Parametrization

//GOALS
Vue.component('goalNavHeader', require('./components/navheaders/GoalsNavHeaderComponent.vue').default);

/*MACROPROCES*/
Vue.component('macroprocessNavHeader', require('./components/navheaders/MacroprocessNavHeaderComponent.vue').default);
Vue.component('subprocesos', require('./components/parameterization_macroprocess/SubprocessComponent.vue').default);
Vue.component('procesos', require('./components/parameterization_macroprocess/ProcessComponent.vue').default);
Vue.component('macroprocesos', require('./components/parameterization_macroprocess/MacroprocessComponent.vue').default);

/*WORK-LOADS*/
Vue.component('workLoadNavHeader', require('./components/navheaders/WorkLoadNavHeaderComponent.vue').default);
Vue.component('parameters', require('./components/parameterization_work_loads/ParametersComponent.vue').default);
Vue.component('subparameters', require('./components/parameterization_work_loads/SubParametersComponent.vue').default);
Vue.component('variables', require('./components/parameterization_work_loads/VariableComponent.vue').default);
Vue.component('parameterstemplates', require('./components/templates/TemplatesParametersComponent.vue').default);
Vue.component('inefficiencyParameters', require('./components/catalog/ParametrizationEfficiencyComponent.vue').default);


/*PSYCHO-SOCIAL*/
Vue.component('psychoAnalisisNavHeader', require('./components/navheaders/PsychoAnalisisNavHeaderComponent.vue').default);
Vue.component('psychosocialQuestions', require('./components/parameterization_psycho_social/PsychosocialQuestionComponent.vue').default);
Vue.component('psychosocialVariables', require('./components/parameterization_psycho_social/PsychosocialVariableComponent.vue').default);
Vue.component('questions', require('./components/parameterization_psycho_social/CriteriaQuestionComponent.vue').default);
Vue.component('psychosocialTemplates', require('./components/templates/TemplatesPychioSocialParametersComponent.vue').default);

//Tasks
Vue.component('taskNavHeader', require('./components/navheaders/TaskNavHeaderComponent.vue').default);
Vue.component('tasks', require('./components/task/TaskManagerComponent.vue').default);
Vue.component('tasksElements', require('./components/task/TaskElementsManagerComponent.vue').default);
Vue.component('tasksUnit', require('./components/task/TaskUnitElementComponent.vue').default);
Vue.component('tasksMeasures', require('./components/task/TaskMeasuresManagerComponent.vue').default);
Vue.component('tasksMeasure', require('./components/task/TaskUnitMeasureComponent.vue').default);

//Measures
Vue.component('settingsMeasure', require('./components/measure/SettingsMeasureComponent.vue').default);
Vue.component('ExtendWorkday', require('./components/measure/ExtendWorkdayComponent.vue').default);

Vue.component('variablesAjusteTiempos', require('./components/assorted/VariableTEComponent.vue').default);
Vue.component('help', require('./components/assorted/HelpComponent.vue').default);


//Templates
Vue.component('categoriesParameters',require('./components/CategoriesComponent.vue').default);
Vue.component('parametersMeasures',require('./components/ParametersMeasureManagerComponent.vue').default);
Vue.component('parameterMeasure', require('./components/ParameterAccordionMeasureComponent.vue').default);
Vue.component('parameterMeasureUnit', require('./components/ParameterUnitMeasureComponent.vue').default);
Vue.component('templatesUsers', require('./components/TemplateUsersComponent.vue').default);

/*Reports*/

Vue.component('goalStatus', require('./components/reports/ReportsGoalsStatus.vue').default);
Vue.component('taskStatus', require('./components/reports/ReportsTasksStatus.vue').default);
Vue.component('reportExample', require('./components/reports/ReportsExample.vue').default);
Vue.component('reportFrecuency', require('./components/reports/ReportsFrecuencies.vue').default);
Vue.component('reportPhva', require('./components/reports/ReportsPHVA.vue').default);
Vue.component('reportCompetences', require('./components/reports/ReportsCompetences.vue').default);
Vue.component('reportEfforts', require('./components/reports/ReportsEfforts.vue').default);
Vue.component('reportsWorkTypes', require('./components/reports/ReportsWorkType.vue').default);
Vue.component('reportsRisks', require('./components/reports/ReportsRisks.vue').default);
Vue.component('reportAddedValue', require('./components/reports/ReportsAddedValue.vue').default);
Vue.component('reportCorelation', require('./components/reports/ReportsCorelation.vue').default);
Vue.component('reportInstrument', require('./components/reports/ReportsInstruments.vue').default);
Vue.component('reportAbc', require('./components/reports/ReportsABC.vue').default);
Vue.component('reportWorkFlow', require('./components/reports/ReportsWorkFlow.vue').default);
Vue.component('reportTimesAndEfficiency', require('./components/reports/ReportsTimesAndEfficiency.vue').default);
Vue.component('reportExcel', require('./components/reports/ReportsExcel.vue').default);

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
