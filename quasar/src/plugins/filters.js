import { parse } from "path";

// import something here

// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  
    Vue.filter('parseDate', function (value) {
      var date = new Date(value);
      var dd = date.getDate();
      dd = dd<10?('0'+ dd) :dd;
      var mm = date.getMonth();
      mm += 1;
      mm = mm<10?('0'+ mm) :mm;
      var yyyy = date.getFullYear();
      return dd + '/' + mm + '/' + yyyy;
    }),

    Vue.filter('parseTime', function(value){
      var hour = parseInt(value)
      var suffix = hour >= 12 ? " PM" : " AM";
      hour = (hour != 12) ? (hour % 12) : hour ;
      return (hour+suffix)
    }),

    Vue.filter('status',function(value){
      return value ? 'Delivered' : 'Pending';
    })
  }
  