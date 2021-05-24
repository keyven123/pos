<template>
    <div class="card">
        <div class="card-body">
            <div class="col-12 my-3 p-0">
                <button class="btn btn-primary btn-sm" @click="$emit('back', 'List')"><i class="fas fa-arrow-left"></i></button>
            </div>
            <form @submit.prevent="updateIngredient()">
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
    name: 'Create',
    mounted() {
        this.fillForm()
    },
    data() {
        return {
            id: null,
            name: null,
            unit: null,
            warning_level: null,
            errors: {},
            search: '',
        }
    },
    methods: {
        async fillForm() {
            this.id = await this.ingredient.id
            this.name = await this.ingredient.name
            this.unit = await this.ingredient.unit
            this.warning_level = await this.ingredient.warning_level
        },
        updateIngredient() {
            var data = {
                id: this.id,
                name: this.name,
                unit: this.unit,
                warning_level: this.warning_level
            }
            this.$store.dispatch("updateIngredient", data)
            .then(response => {
                if(response.success) {
                    this.$emit('back', 'List')
                }
                this.errors = {}
            }).catch(error => {
                    if(error.response.status === 422) {
                        this.errors = error.response.data.errors
                        Swal.fire('Error', error.response.data.message , 'error')
                    }
                })
        }
        
    },
    computed: {
        ...mapGetters({
            ingredient: "ingredient"
        })
    }
};
</script>

<style>
.btn-primary {
    color: white;
}
</style>