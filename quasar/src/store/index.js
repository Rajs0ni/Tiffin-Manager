import Vue from 'vue'
import Vuex from 'vuex'

import Tiffin from './Tiffin'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default new Vuex.Store({

    modules: {
     Tiffin
    }
  })



