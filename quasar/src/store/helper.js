import { LocalStorage } from 'quasar'
import store from '../store'

export default {

    isLoggedIn(){
     return store.state.Tiffin.customer.isLoggedIn
    },
    

    setCustomerFromStorage()
    {
      if(LocalStorage.has('customer') && LocalStorage.has('customer_secret'))
      {
        var customer = LocalStorage.get.item('customer')
        if(customer && customer['name'] && customer['location'])
          store.dispatch('Tiffin/setCustomerFromStorage',customer)
        else
          store.state.Tiffin.customer.isLoggedIn = false
      }
      else
        store.state.Tiffin.customer.isLoggedIn = false
    }
}