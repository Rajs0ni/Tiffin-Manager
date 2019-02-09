import {Axios} from 'plugins/axios.js'
// import { LocalStorage } from 'quasar'
// Axios.defaults.headers.common['Authorization'] = LocalStorage.get.item('customer_secret');

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
            provider_id:payload.customer.assoc_provider,
            tiffin_id:payload.customer.tiffin_plan,
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
            customer:payload.customer,
            quantity:payload.quantity,
            data:payload.data,
            time:payload.time
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
 },

 getOTP(payload){
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
 },

 register(payload){
    return Axios.post('',{
        namespace:"Customer",
        action:"save",
        payload:{
            customer:payload.customer
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
 },

 getCustomer(payload){
    return Axios.post('',{
        namespace:"Customer",
        action:"get",
        payload:{
            customer:payload.customer
        }
    })
    .then((response) => (response.data))
    .catch((error) => (error))
 }
}