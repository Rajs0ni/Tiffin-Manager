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
    }
}

