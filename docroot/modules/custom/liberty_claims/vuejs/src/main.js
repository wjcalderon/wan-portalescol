import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import VTooltip from 'v-tooltip'

Vue.use(VueResource)
Vue.use(Loading)
Vue.use(VTooltip, {defaultTrigger: 'hover focus click'})

Vue.directive('uppercase', {
	update (el) {
		el.value = el.value.toUpperCase()
	},
})

new Vue({
  el: '#coveredApp',
  render: h => h(App)
})
