<template>
    <v-dialog :value="visible" max-width="550px" persistent @input="$emit('close')">
        <v-card>
            <v-toolbar flat dense color="primary" dark>
                <v-toolbar-title>{{ dialogTitle }}</v-toolbar-title>
                <v-spacer />
                <v-btn icon dark @click="$emit('close')">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>

            <v-card-text class="pt-6 pb-0">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="form.registrationNumber"
                            label="Registration number"
                            prepend-inner-icon="mdi-card-text"
                            outlined
                            dense
                            hide-details="auto"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.brand"
                            label="Brand"
                            prepend-inner-icon="mdi-car"
                            outlined
                            dense
                            hide-details="auto"
                        />
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            v-model="form.model"
                            label="Model"
                            prepend-inner-icon="mdi-car-info"
                            outlined
                            dense
                            hide-details="auto"
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            v-model="form.type"
                            :items="vehicleTypes"
                            label="Vehicle type"
                            prepend-inner-icon="mdi-tag"
                            outlined
                            dense
                            hide-details="auto"
                        />
                    </v-col>
                </v-row>
            </v-card-text>

            <v-divider />

            <v-card-actions class="pa-4">
                <v-spacer />
                <v-btn outlined @click="$emit('close')" class="text-none mr-2">
                    Cancel
                </v-btn>
                <v-btn color="primary" depressed @click="$emit('submit', form)" class="text-none">
                    <v-icon left small>{{ isEditing ? 'mdi-content-save-edit' : 'mdi-plus' }}</v-icon>
                    {{ isEditing ? 'Save changes' : 'Add vehicle' }}
                </v-btn>
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
const dialogTitle = computed(() => isEditing.value ? 'Edit vehicle' : 'Add vehicle')

watch(() => props.visible, (val) => {
    if (!val) return
    form.value = Object.assign(CREATE_EDIT_VEHICLE_FORM_DEFAULTS(), props.vehicle)
})
</script>
