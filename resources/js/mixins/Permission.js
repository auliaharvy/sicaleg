import store from '../store'
export default {
    methods: {
        $can(permissionName){
            // MENGAMBIL PERMISSION DARI USER YANG SEDANG LOGIN
            let Permission = store.state.user.authenticated.permission;
            // JIKA USER MEMPUNYAI PERMISSION YANG TERKAIT MAKA AKAN ME RETURN KAN TRUE
            if(typeof Permission != 'undefined') return Permission.indexOf(permissionName) !== -1;
        }
   }
}