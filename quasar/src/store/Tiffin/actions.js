import { API } from '../api.js';
import * as types from '../types.js';
export const actions = {

    async filterResponse({commit, dispatch},response){

        var type = response.status !== 200 ? 'negative' : 'positive'
        var icon = type == 'negative' ? 'error' : 'done';
        var message = response.flash_message
        if(message)
            dispatch('setFlash',{icon,type,message})
        return response.data 
    },

    async setProviderOrders({commit},payload){
        var response = await API.getOrders(payload)
        commit(types.SET_PROVIDERS_ALL_ORDERS, response.data)
    },

    async setCustomerOrders({commit},payload){
        var response = await API.getOrders(payload)
        commit(types.SET_CUSTOMERS_ALL_ORDERS, response.data)
    },

    async setCustomerMenu({commit, dispatch}, payload){
        var response = await API.getMenu(payload)
        commit(types.SET_CUSTOMER_MENU, response.data)
    },
    
    async setProviderMenu({commit}, payload){
        var response = await API.getMenu(payload)
        commit(types.SET_PROVIDER_MENU, response.data)
    },
    
    async setCustomerOrder({commit},payload){
        var response = await API.getOrder(payload)
        commit(types.SET_CUSTOMER_ORDER, response.data)
    },
    
    async setProviderOrder({commit},payload){
        var response = await API.getOrder(payload)
        commit(types.SET_PROVIDER_ORDER, response.data)
    },

    async processOrder({commit, dispatch}, payload)
    {
        var response = await API.processOrder(payload)   
        dispatch('filterResponse',response)
    },

    async saveOrder({commit, dispatch}, payload)
    {
        var response = await API.saveOrder(payload)
        dispatch('filterResponse',response)
    },

    async getOTP({commit, dispatch},payload)
    {
        var response = await API.getOTP(payload)
        dispatch('filterResponse',response)
        if(response.status==200)
            payload.callback();
    },

    async verifyOTP({commit, dispatch},payload){
        var response = await API.verifyOTP(payload)
        dispatch('filterResponse',response)
        .then((response)=>{
            commit(types.SET_CUSTOMER, response)
        })
        if(response.status==200)
        payload.callback(response);
    },

    async register({commit, dispatch},payload){
        var response = await API.register(payload)
        dispatch('filterResponse',response)
        .then((response)=>{
            commit(types.SET_CUSTOMER, response)
        })
        if(response.status==200)
        payload.callback(response);
    },

    async getCustomer({commit, dispatch},payload){
        var response = await API.getCustomer(payload)
        dispatch('filterResponse',response)
        .then((response)=>{
            commit(types.SET_CUSTOMER, response)
        })
    },

    async setCustomerFromStorage({commit, dispatch},payload){
        commit(types.SET_CUSTOMER, payload)
    },

    async setFlash({commit}, payload)
    {
        commit(types.SET_FLASH, payload)
        setTimeout(function(){
            commit(types.RESET_FLASH) 
        },3000)
    }
}
