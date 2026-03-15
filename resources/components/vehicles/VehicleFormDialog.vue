<template>
    <v-dialog :value="visible" max-width="500px" @input="$emit('close')">
        <v-card>
            <v-card-title>{{ isEditing ? 'Edit Vehicle' : 'Add Vehicle' }}</v-card-title>
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
import { ref, watch } from 'vue'

const VEHICLE_TYPES = ['Passenger', 'Bus', 'Truck']

const props = defineProps({
    visible: { type: Boolean, default: false },
    vehicle: { type: Object, default: null },
})

defineEmits(['close', 'submit'])

const vehicleTypes = VEHICLE_TYPES
const isEditing = ref(false)
const form = ref(createEmptyForm())

function createEmptyForm() {
    return { registrationNumber: '', brand: '', model: '', type: '' }
}

watch(() => props.visible, (val) => {
    if (!val) return
    if (props.vehicle) {
        isEditing.value = true
        form.value = {
            registrationNumber: props.vehicle.registrationNumber,
            brand: props.vehicle.brand,
            model: props.vehicle.model,
            type: props.vehicle.type,
        }
    } else {
        isEditing.value = false
        form.value = createEmptyForm()
    }
})
</script>
