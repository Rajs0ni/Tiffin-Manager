import {Axios} from 'plugins/axios.js'

export const API = {
    
 getProviderOrders(){
    return Axios.post('',{
        namespace:'Order',
        action:'list',
        payload:{
          user_id:1
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 getCustomerOrders(){
    return Axios.post('',{
        namespace:'Order',
        action:'list',
        payload:{
          user_id:2
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 getCustomerMenu(payload){
    return Axios.post('',{
        namespace:"Tiffin",
        action:"getMenu",
        payload:{
            provider_id:1,
            tiffin_id:1,
            day:payload.menuDay
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 getProviderMenu(payload){
    return Axios.post('',{
        namespace:"Tiffin",
        action:"getMenu",
        payload:{
            provider_id:1,
            tiffin_id:1,
            day:payload.menuDay
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 processOrder(payload){
    return Axios.post('',{
        namespace:"Order",
        action:"deliver",
        payload:{
            user_id:1,
            order_id:payload.order_id
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 saveOrder(payload){
    return Axios.post('',{
        namespace:"Order",
        action:"save",
        payload:{
            customer_id:2,
            quantity:payload.quantity,
            // tiffin_id:payload.tiffin_id,
            data:payload.data,
            time:payload.time
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
}

}