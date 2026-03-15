<template>
    <v-dialog :value="visible" max-width="500px" @input="$emit('close')">
        <v-card>
            <v-card-title>{{ dialogTitle }}</v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="form.registrationNumber"
                    label="Registration Number"
                />
                <v-text-field
                    v-model="form.brand"
                    label="Brand"
                />
                <v-text-field
                    v-model="form.model"
                    label="Model"
                />
                <v-select
                    v-model="form.type"
                    :items="vehicleTypes"
                    label="Vehicle Type"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn text @click="$emit('close')">Cancel</v-btn>
                <v-btn color="primary" @click="$emit('submit', form)">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { VEHICLE_TYPES, CREATE_EDIT_VEHICLE_FORM_DEFAULTS } from './constants'


const props = defineProps({
    visible: { type: Boolean, default: false },
    vehicle: { type: Object, default: () => ({}) },
})


defineEmits(['close', 'submit'])


const vehicleTypes = VEHICLE_TYPES
const form = ref(CREATE_EDIT_VEHICLE_FORM_DEFAULTS())

const isEditing = computed(() => !!props.vehicle.id)
const dialogTitle = computed(() => isEditing.value ? 'Edit Vehicle' : 'Add Vehicle')


watch(() => props.visible, (val) => {
    if (!val) return
    form.value = Object.assign(CREATE_EDIT_VEHICLE_FORM_DEFAULTS(), props.vehicle)
})
</script>
