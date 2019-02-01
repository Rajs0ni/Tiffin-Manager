import {Axios} from 'plugins/axios.js'

export const API = {
    
 getOrders(payload){
    return Axios.post('',{
        namespace:'Order',
        action:'list',
        payload:{
          user_id:payload.user_id
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 getOrder(payload){
    return Axios.post('',{
        namespace:'Order',
        action:'get',
        payload:{
           user_id:payload.user_id,
           order_id:payload.order_id
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 getMenu(payload){
    return Axios.post('',{
        namespace:"TiffinMenu",
        action:"get",
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
            data:payload.data,
            time:payload.time
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
},

 getOTP(payload){
    alert(payload.customer)
    return Axios.post('',{
        namespace:"Authenticate",
        action:"getOTP",
        payload:{
            customer:payload.customer
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
 },

 verifyOTP(payload){
    return Axios.post('',{
        namespace:"Authenticate",
        action:"verifyOTP",
        payload:{
            customer:payload.customer
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
}
}