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
      if(LocalStorage.has('customer') && LocalStorage.has('customer_secret'))
      {
        var customer = LocalStorage.get.item('customer')
        var customer_secret = LocalStorage.get.item('customer_secret')
          if(customer && customer_secret)
          {
            if(to.fullPath == '/verify')
               Router.go(-1)
            next()
          }
             
          else
            next('/verify') 
      }
      else
          next('/verify')
    }else if (to.matched.some(record => record.meta.redirectIfLogged)) {
      if (LocalStorage.has('customer') && LocalStorage.has('customer_secret')) {
        next({
          path: '/'
        })
      } else {
        next()
      }
    } else {
      next()
    }
      next()
   }) 
   
  return Router
}
