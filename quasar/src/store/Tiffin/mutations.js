import * as types from './types.js';

 export const mutations =  {

    [types.SET_PROVIDERS_ALL_ORDERS](state, response)
    {
        state.provider.orders = response
    },

    [types.SET_CUSTOMERS_ALL_ORDERS](state, response)
    {
        state.customer.orders = response
    },

    [types.SET_CUSTOMER_MENU](state, response)
    {
        state.customer.menu = response
    },

    [types.SET_PROVIDER_MENU](state, response){

        state.provider.menu = response
    },

    [types.SET_CUSTOMER_ORDER](state, response)
    {
        state.customer.order = response
    },

    [types.SET_PROVIDER_ORDER](state, response)
    {
        state.provider.order = response
    },

    [types.SET_FLASH](state, response){
        state.flash_message = response
    },

    [types.RESET_FLASH](state){
        state.flash_message = null
    }
}

