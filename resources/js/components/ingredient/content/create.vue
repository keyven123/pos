<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="addIngredients()">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-4">
                    <label class="col-form-label pt-0">Ingredients Name</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('name')}" type="text" placeholder="Ingredients name" v-model="name">
                        <label v-if="errors.hasOwnProperty('name')" class="text-danger">{{errors.name[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Unit</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('unit')}" type="text" placeholder="Unit ex. Kg, Liter" v-model="unit">
                        <label v-if="errors.hasOwnProperty('unit')" class="text-danger">{{errors.unit[0]}}</label>
                    </div>
                    <div class="col-4">
                    <label class="col-form-label pt-0">Warning level</label>
                        <input class="form-control" :class="{'is-invalid border border-danger': errors.hasOwnProperty('warning_level')}" type="text" placeholder="Default 5 Units" v-model="warning_level">
                        <label v-if="errors.hasOwnProperty('warning_level')" class="text-danger">{{errors.warning_level[0]}}</label>
                    </div>
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
    name: 'Ingredients',
    mounted() {
        
    },
    data() {
        return {
            name: null,
            unit: null,
            warning_level: 5,
            errors: {},
            search: '',
        }
    },
    methods: {
        ...mapActions({
            createIngredient: "createIngredient"
        }),
        addIngredients() {
            const data = {
                name: this.name,
                unit: this.unit,
                warning_level: this.warning_level,
            }
            this.createIngredient(data)
            .then(response => {
                if (response.success) {
                    this.name =  null
                    this.unit =  null
                    this.warning_level = 5,
                    this.errors = {}
                    Swal.fire({
                        position: 'top-end',
                        icon: response.alert_type,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }).catch(error => {
                this.errors = error.response.data.errors
                Swal.fire('Error', error.response.data.message , 'error')
            })
        }
        
    },
    computed: {
        ...mapGetters({
            
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>