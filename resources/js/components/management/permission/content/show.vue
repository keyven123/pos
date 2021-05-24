<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="updatePermission()">
            <div class="form-group">
                <div class="col-6">
                <label class="col-form-label pt-0">Permission Name</label>
                    <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}" type="text" placeholder="First name" v-model="name">
                    <label v-if="errors.hasOwnProperty('name')" class="text-danger">{{errors.name[0]}}</label>
                </div>
            </div>
            <button class="btn btn-primary" type="submit" style="color: #fff">Submit</button>
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
    },
    data() {
        return {
            name: null,
            errors: {},
            search: '',
        }
    },
    methods: {
        async fillForm() {
            this.name = await this.permission.name
        },
        updatePermission() {
            var data = {
                name: this.name
            }
            this.$store.dispatch("updatePermission", data)
            .then(response => {
                if(response.success) {
                    this.$emit('back', 'List')
                }
            })
        }
        
    },
    computed: {
        ...mapGetters({
            permission: "permission"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>