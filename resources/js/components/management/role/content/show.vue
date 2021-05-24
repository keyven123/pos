<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="updateRolePermissions()">
            <div class="form-group">
                <div class="col-4">
                <label class="col-form-label pt-0">Role Name</label>
                    <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}" type="text" placeholder="First name" v-model="name">
                    <label v-if="errors.hasOwnProperty('name')" class="text-danger">{{errors.name[0]}}</label>
                </div>
            </div>
            <table class="table" style="text-transform: capitalize;">
            <thead>
                <tr>
                    <th scope="col">Permission Name</th>
                    <th scope="col" v-for="(action, index) in actions" :key="index">{{action}}</th>
                </tr>
            </thead>
            <tbody class="border-bottom">
                <tr>
                    <td></td>
                    <td v-for="(action, index) in actions" :key="index"><input type="checkbox" @change="selectRowPermissions(action)" v-model="selected_row_permissions" :value="action"></td>
                </tr>
                <tr v-for="(permission, index) in permissionsNameSplitted" :key="index">
                    <td>{{permission.alias}}</td>
                    <td v-for="(action, index) in actions" :key="index"><input type="checkbox" v-model="selected_permissions" :value="`${permission.name}-${action}`"></td>
                </tr>
            </tbody>
        </table>
            <button class="btn btn-primary" type="submit" style="color: #fff">Update</button>
        </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'Create',
    mounted() {
        this.fillForm()
        this.$store.dispatch('getAllPermissions')
        .then(() => {
            this.role.permissions.forEach(permission => {
                this.selected_permissions.push(permission.name)
            })
            
        })
    },
    data() {
        return {
            id:null,
            name: null,
            errors: {},
            search: '',
            selected_row_permissions: [],
            selected_permissions: [],
        }
    },
    methods: {
        ...mapActions({
            updateRole: "updateRole"
        }),
        async fillForm() {
            this.name = await this.role.name
        },
        updateRolePermissions() {
            const data = {
                id: this.id,
                name: this.name,
                guard_name: "web",
                permissions: this.selected_permissions
            }
            this.updateRole(data)
            .then(response => {
                if (response.success) {
                    this.name =  null
                    Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                this.$emit('back', 'List')
            }).catch(error => {
                this.errors = error.response.data.errors
                Swal.fire('Error', error.response.data.message , 'error')
            })
        },
        selectRowPermissions(action) {
            if(this.selected_row_permissions.indexOf(action) < 0) {
                this.selected_permissions = this.selected_permissions.filter(permission => (permission.indexOf(action) < 0))
            } else {
                this.selected_row_permissions.forEach(selected => {
                if(selected === action) {
                        this.allPermissions.forEach(permission => {
                            if(permission.name.indexOf(action) > -1 && !this.selected_permissions.includes(permission.name)) {
                                this.selected_permissions.push(permission.name)
                            }
                        })
                    }
                })
            }
        },
    },
    computed: {
        ...mapGetters({
            role: "role",
            allPermissions: "allPermissions"
        }),
        actions() {
            var actions = []
            this.allPermissions.forEach(permission => {
                var splitted_name = permission.name.split('-')
                if(splitted_name.length <= 2 && !actions.includes(splitted_name[1])) {
                    actions.push(splitted_name[1])
                }
            });
            return actions
        },
        permissionsNameSplitted() {
            var permissions = []
            this.allPermissions.forEach(permission => {
                var splitted_name = permission.name.split('-')
                var name = ''
                if(splitted_name.length > 2) {
                    name = splitted_name[0] + '-' + splitted_name[1]
                    if(!permissions.some(permission => (permission.name === name))) {
                        return permissions.push({
                            name: name,
                            alias: `${name}`
                        })
                    }
                } else {
                    name = splitted_name[0]
                    if(!permissions.some(permission => (permission.name === name))) {
                        return permissions.push({
                            name: name,
                            alias: `${name}`
                        })
                    }
                }
            })
            return permissions.sort((a, b) => a.name.localeCompare(b.name))
        }
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>