import {Axios} from 'plugins/axios.js';

export const API = {
    parseAPIResponse(response){
    if(response.data.status==200) {
        setAPIFlashMessage(
            response.data.flash_message,
            'success'
        );
    }else {
        console.log(response.data.flash_message)
        setAPIFlashMessage(
            response.data.flash_message,
            'error'
        )
    }
    return response.data
},

  setAPIFlashMessage(message,message_type){
    store.dispatch (type.SET_FLASH_MESSAGE,{
        message:message,
        message_type:message_type
    })       
    setTimeout(function(){
        store.dispatch(type.RESET_FLASH_MESSAGE)
    },4000)
},

 saveProduct(form_data){
    return axios
        .post(BASE_API_URL,{
            namespace:'ProductApi',
            action:'save',
            payload:form_data
        }).then(function(response) {
            var data=parseAPIResponse(response)
            return data;

        }).catch(function(error) {
            return error;
            
        });
    
},

 getProviderOrders(){
    return Axios.post('',{
        namespace:'Order',
        action:'list',
        payload:{
          "user_id":1
        }
    }).then((response) => {
        var data = response.data.data
        return data;
    }).catch((error)=>(error));
},

 getCustomerOrders(){
    return Axios.post('',{
        namespace:'Order',
        action:'list',
        payload:{
          "user_id":2
        }
    }).then((response) => {
        var data  = response.data.data
        return data
    }).catch((error)=>(error))
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
    }).then((response) => {
        var data  = response.data.data
        return data
    }).catch((error)=>(error))
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
    }).then((response) => {
        var data  = response.data.data
        return data
    }).catch((error)=>(error))
},

 processOrder(payload){
    return Axios.post('',{
        namespace:"Order",
        action:"deliver",
        payload:{
            user_id:1,
            order_id:payload.order_id
        }
    }).then((response) => {
        var data  = response.data
        return data
    }).catch((error)=>(error))
},

 deliverOrder(payload){
    return Axios.post('',{
        namespace:"Order",
        action:"save",
        payload:{
            customer_id:2,
            quantity:payload.quantity,
            price:payload.price,
            time:payload.time
    }
    }).then((response) => {
        var data  = response.data
        return data
    }).catch((error)=>(error))
}

}