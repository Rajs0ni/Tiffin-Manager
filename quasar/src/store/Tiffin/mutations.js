import * as types from '../types';

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
        state.user.id = response.id 
        state.user.name = response.name 
        state.user.mobile = response.mobile
        state.user.location = response.location
        state.user.tiffin_plan = response.tiffin_plan
        state.user.assoc_provider = response.assoc_provider
        state.user.remember_token = response.remember_token
        
        state.user.isLoggedIn = true;
    },

    [types.SET_PROVIDERS](state, response)
    {
        state.providers = response
    }
}

