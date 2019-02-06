// import { LocalStorage } from 'quasar'
import store from '../store/Tiffin'

export default {

    isLoggedIn(){
      return store.state.customer.isLoggedIn
    }
}