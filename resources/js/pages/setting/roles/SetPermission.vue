<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Assign Role to User</h3>
                    </div>
                  	<!-- FORM UNTUK MENAMBAHKAN ROLE KE USERS -->
                    <div class="panel-body">
                        <div class="alert alert-success" v-if="alert_role">Role Has Been Added</div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select class="form-control" v-model="role_user.role">
                                <option value="">Pilih</option>
                                <option v-for="(row, index) in roles" :value="row.id" :key="index">{{ row.name }}</option>
                            </select>
                            <p class="text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">User</label>
                            <select class="form-control" v-model="role_user.user_id">
                                <option value="">Pilih</option>
                                <option v-for="(row, index) in users" :value="row.id" :key="index">{{ row.name }} ({{row.email}})</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger btn-sm" @click="setRole">Set Role</button>
                        </div>
                    </div>
                    <!-- FORM UNTUK MENAMBAHKAN ROLE KE USERS -->
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel">
                    <div class="panel-heading"><h3 class="panel-title">Set Permission</h3></div>
                  	<!-- FORM UNTUK MENAMBAHKAN PERMISSION KE MASING-MASING ROLE -->
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="">Role</label>
                            <select class="form-control" v-model="role_selected">
                                <option value="">Pilih</option>
                                <option v-for="(row, index) in roles" :value="row.id" :key="index">{{ row.name }}</option>
                            </select>
                            <p class="text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm" @click="checkPermission">{{ loading ? 'Loading...':'Check' }}</button>
                        </div>
                        <div class="form-group">
                            <div class="alert alert-success" v-if="alert_permission">Permission has been assigned</div>
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">Permissions</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <template v-for="(row, index) in permissions">
                                            <div>
                                                <input type="checkbox" 
                                                    class="minimal-red" 
                                                    :key="index"
                                                    :value="row.name"
                                                    :checked="role_permission.findIndex(x => x.name == row.name) != -1"
                                                    @click="addPermission(row.name)"
                                                    > {{ row.name }} <br :key="'row' + index">
                                                <br :key="'enter' + index" v-if="(index+1) %4 == 0">
                                            </div>
                                       </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-primary btn-sm" @click="setPermission">
                                <i class="fa fa-send"></i> Set Permission
                            </button>
                        </div>
                    </div>
                    <!-- FORM UNTUK MENAMBAHKAN PERMISSION KE MASING-MASING ROLE -->
                  
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapMutations, mapState } from 'vuex';

    export default {
        name: 'SetPermission',
        data(){
            return {
                role_user: {
                    role: '',
                    user_id: ''
                },
                role_selected: '',
                new_permission: [],
                loading: false,
                alert_role: false,
                alert_permission: false,
            }
        },
        created(){
            // KETIKA DI LOAD, AKAN MEMANGGIL SEMUA DATA ROLE, PERMISSION DAN USER
            this.getRoles()
            this.getAllPermission()
            this.getUserLists()
        },
        computed: {
            // KETIKA DI LOAD, AKAN MEMANGGIL SEMUA DATA STATE USERS, ROLES, PERMISSIONS DAN ROLE_PERMISSION
            ...mapState(['errors']),
            ...mapState('user', {
                users: state => state.users,
                roles: state => state.roles,
                permissions: state => state.permissions,
                role_permission: state => state.role_permission
            })
        },
        methods: {
            ...mapActions('user', [
                'getUserLists',
                'getRoles',
                'getAllPermission',
                'getRolePermission',
                'setRolePermission',
                'setRoleUser',
            ]),
            ...mapMutations('user', ['CLEAR_ROLE_PERMISSION']),
            setRole(){
                this.setRoleUser(this.role_user).then(() => {
                    // SET TRUE UNTUK MEMUNCULKAN ALERT SUKSES MEMBUAT ROLE
                    this.alert_role = true;
                    // DALAM 1 DETIK V-MODEL ROLE DAN USER_ID DIUBAH MENJADI STRING KOSONG DAN ALERT SUKSES AKAN HILANG
                    setTimeout(() => {
                        this.role_user = {
                            role: '',
                            user_id: ''
                        }
                        this.alert_role = false;
                    }, 1000)
                })
            },
            addPermission(name){
                // MENCARI INDEX KE BERAPA YANG DATA NAMA PERMISSION NYA SAMA DENGAN PARAMETER NAMA YANG DIBERIKAN (dari addPermission)
                let index = this.new_permission.findIndex(x => x == name)
                // JIKA ARRAY MEMPUNYAI INDEX KE 0 MAKA MEMPUNYAI NILAI JIKA TIDAK PUNYA MAKA ITU ADALAH ARRAY KOSONG
                // JADI INI AKAN MELAKUKAN PENAMBAHAN PERMISSION BARU JIKA VARIABLE INDEX ADALAH ARRAY KOSONG
                // index == -1 ? this.new_permission.push(name) : this.new_permission.splice(index, 1)
                // if(index == -1) this.new_permission.push(name)
                // if(index != -1) this.new_permission.splice(index, 1)
                if(index == -1){
                    this.new_permission.push(name)
                }else{
                    this.new_permission.splice(index, 1)
                }

                console.log(this.new_permission)
            },
            checkPermission(){
                this.loading = true;
                this.getRolePermission(this.role_selected).then(() => {
                    // MEMUNCULKAN ALERT LOADING 
                    this.loading = false;
                    // NGE MERGE DATA ROLE_PERMISSION KE NEW_PERMISSION
                    this.new_permission = this.role_permission
                })
            },
            setPermission(){
                this.setRolePermission({
                    role_id: this.role_selected,
                    permissions: this.new_permission
                }).then((res) => {
                    if(res.status == 'success'){
                        // JIKA SUKSES AKAN MEMUNCULKAN ALERT SUKSES MENAMBAH PERMISSION
                        this.alert_permission = true;
                        // DALAM 1 DETIK ALERT AKAN HILANG
                        setTimeout(() => {
                            this.role_selected = '',
                            this.new_permission = [],
                            this.loading = false,
                            this.alert_permission = false,
                            this.CLEAR_ROLE_PERMISSION()
                        }, 1000)
                    }
                })
            }
        }
    }
</script>

<style type="text/css">
    .tab-pane{
        height:150px;
        overflow-y:scroll;
    }
</style>