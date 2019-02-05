import Vue from 'vue'
import VueRouter from 'vue-router'
import { LocalStorage } from 'quasar'
import routes from './routes'

Vue.use(VueRouter)

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation
 */

export default function (/* { store, ssrContext } */) {
  const Router = new VueRouter({
    scrollBehavior: () => ({ y: 0 }),
    routes,

    // Leave these as is and change from quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    mode: process.env.VUE_ROUTER_MODE,
    base: process.env.VUE_ROUTER_BASE
  })

  Router.beforeEach((to,from,next)=>{
    if(to.matched.some(record => record.meta.requiresAuth))
    {

     var customer = JSON.parse(LocalStorage.has('customer'))
     if(customer)
     {
       if(customer.customer_secret)
       {
         next()
       }
     }
     else
       next('/verify') 
    }
    next()
   }) 
   
  return Router
}
