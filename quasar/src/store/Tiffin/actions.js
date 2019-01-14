import {API} from './api.js';
import * as types from './types.js';

export const actions = {

    filterResponse(response){
        // var message = response.flash_message
        // var type = response.status !== 200 ? 'negative' : 'positive'
        // setFlash({type,message})
        // return response.data
        alert(response.status)
    },

    async setProviderOrders({commit}){
        var response = await API.getProviderOrders()
        // response = filterResponse(response)
        commit(types.SET_PROVIDERS_ALL_ORDERS, response.data)
    },

    async setCustomerOrders({commit}){
        var response = await API.getCustomerOrders()
        // response = filterResponse(response)
        commit(types.SET_CUSTOMERS_ALL_ORDERS, response.data)
    },

    async setCustomerMenu({commit}, payload){
        var response = await API.getCustomerMenu(payload)
            // filterResponse(response)
       
        commit(types.SET_CUSTOMER_MENU, response.data)
    },

    async setProviderMenu({commit}, payload){
        var response = await API.getProviderMenu(payload)
        // response = filterResponse(response)
        commit(types.SET_PROVIDER_MENU, response.data)
    },

    async processOrder({commit}, payload)
    {
        var response = await API.processOrder(payload)
        // response = filterResponse(response)
        commit(types.SET_FLASH, response)
    },

    async saveOrder({commit}, payload)
    {
        var response = await API.saveOrder(payload)
        // response = filterResponse(response)
        commit(types.SET_FLASH, response)
    },

    // async setFlash({commit}, payload)
    // {
    //     console.log(payload.type)
    // }
}
