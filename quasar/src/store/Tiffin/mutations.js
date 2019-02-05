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
    },

    [types.SET_CUSTOMER](state, response)
    {
        state.customer.detail.id = response.id 
        state.customer.detail.name = response.name 
        state.customer.detail.mobile = response.mobile
        state.customer.detail.location = response.location
        state.customer.detail.tiffin_plan = response.tiffin_plan
        state.customer.detail.assoc_provider = response.assoc_provider
        state.customer.detail.customer_secret = response.remember_token

        state.customer.isLoggedIn = true;
    }
}

