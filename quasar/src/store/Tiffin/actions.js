import * as types from './types.js'
import { API } from './api.js';

export const actions = {

    async setProviderOrders(context){
        var data = await API.getProviderOrders()
        context.commit(types.SET_PROVIDERS_ALL_ORDERS, data)
    },

    async setCustomerOrders(context){
        var data = await API.getCustomerOrders()
        context.commit(types.SET_CUSTOMERS_ALL_ORDERS, data)
    },

    async setCustomerMenu(context,payload){
        var data = await API.getCustomerMenu(payload)
        context.commit(types.SET_CUSTOMER_MENU, data)
    },

    async setProviderMenu(context,payload){
        var data = await API.getProviderMenu(payload)
        context.commit(types.SET_PROVIDER_MENU, data)
    },
    async processOrder (context,payload)
    {
        var data = await API.processOrder(payload)
        context.commit(types.SET_FLASH, data)
    },
    async deliverOrder (context,payload)
    {
        var data = await API.deliverOrder(payload)
        context.commit(types.SET_FLASH, data)
    }
}
