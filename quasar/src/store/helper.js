import { LocalStorage } from 'quasar'
import store from '../store'

export default {

    isLoggedIn(){
     return store.state.Tiffin.user.isLoggedIn
    },
    
    isLocallySet()
    {
      if(LocalStorage.has('customer'))
      {
        var customer = LocalStorage.get.item('customer')
        if(customer && customer['name'] && customer['location'])
          return true 
        else
          return false
      }
      else
        return false
    },

    setCustomerFromStorage()
    {
      if(LocalStorage.has('customer') && LocalStorage.has('customer_secret'))
      {
        var customer = LocalStorage.get.item('customer')
        if(customer && customer['name'] && customer['location'])
          store.commit('Tiffin/SET_CUSTOMER',customer)
        else
           store.state.Tiffin.user.isLoggedIn = false
      }
      else
          store.state.Tiffin.user.isLoggedIn = false
    }
}