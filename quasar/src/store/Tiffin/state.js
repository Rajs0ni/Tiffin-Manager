export default () => ({
  customer:{
    menu:{},
    orders:[],
    order:{},
    detail:{
      id:'',
      name:'',
      mobile:'',
      location:'',
      otp:'',
      tiffin_plan:'',
      assoc_provider:'',
      customer_secret:''
    },
    isLoggedIn : false
  },

  provider:{
    menu:{},
    orders:[],
    order:{}
  },
  
  flash_message:''
})

