import Vue from 'vue'
import VueRouter from 'vue-router'
import helper from '../store/helper'
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
        if(helper.isLoggedIn() || helper.isLocallySet())
        {
          next()
        }
        else
          next('/verify')
      }
      else if(to.matched.some(record => record.meta.redirectIfLogged))
      {
        if(helper.isLoggedIn() || helper.isLocallySet())
        {
          Router.go(-1)
        }
        else
          next()
      }
   }) 

  return Router
}
