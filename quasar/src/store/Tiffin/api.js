export const parseAPIResponse=function(response) {
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
}

export const setAPIFlashMessage = function(message,message_type) {
    store.dispatch (type.SET_FLASH_MESSAGE,{
        message:message,
        message_type:message_type
    })       
    setTimeout(function(){
        store.dispatch(type.RESET_FLASH_MESSAGE)
    },4000)
}

export const saveProduct=function(form_data){
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
    
}