<template>
    <v-container>
        <v-card>
        <Table
            ref="datagrid"
            url="/vehicles/list"
            :table-headers="headers"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Vehicles</v-toolbar-title>
                    <v-spacer />
                    <v-btn color="primary" small @click="handleAddClick">
                        <v-icon left small>mdi-plus</v-icon>
                        Add
                    </v-btn>
                </v-toolbar>
            </template>

            <template v-slot:item.no="{ index }">
                {{ index + 1 }}
            </template>

            <template v-slot:item.registrationNumber="{ item }">
                {{ String(item.registrationNumber).toUpperCase() }}
            </template>

            <template v-slot:item.createdAt="{ item }">
                {{ formatDate(item.createdAt) }}
            </template>

            <template v-slot:item.updatedAt="{ item }">
                {{ formatDate(item.updatedAt) }}
            </template>

            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="handleEditClick(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="handleDeleteClick(item)">
                    mdi-delete
                </v-icon>
            </template>
        </Table>
        </v-card>

        <VehicleFormDialog
            :visible="formDialog.visible"
            :vehicle="formDialog.vehicle"
            @close="formDialog.visible = false"
            @submit="handleFormSubmit"
        />
    </v-container>
</template>

<script setup>
import { ref, reactive, getCurrentInstance } from 'vue'
import { format, fromUnixTime } from 'date-fns'
import { saveVehicle, removeVehicle } from '../api/vehicles'
import Table from '../components/Table.vue'
import VehicleFormDialog from '../components/vehicles/VehicleFormDialog.vue'

const { proxy } = getCurrentInstance()
const datagrid = ref(null)

const headers = [
    { text: 'No.', value: 'no', sortable: false, width: '60px' },
    { text: 'Registration Number', value: 'registrationNumber', width: '180px' },
    { text: 'Brand', value: 'brand', width: '120px' },
    { text: 'Model', value: 'model', width: '120px' },
    { text: 'Vehicle Type', value: 'type', width: '130px' },
    { text: 'Creation Date', value: 'createdAt', width: '170px' },
    { text: 'Modification Date', value: 'updatedAt', width: '180px' },
    { text: 'Actions', value: 'actions', sortable: false, align: 'center', width: '100px' },
]

const formDialog = reactive({ visible: false, vehicle: null })

function formatDate(timestamp) {
    if (!timestamp) return ''
    return format(fromUnixTime(timestamp), 'dd/MM/yyyy HH:mm')
}

function refreshDatagrid() {
    datagrid.value.refresh()
}

function handleAddClick() {
    formDialog.vehicle = null
    formDialog.visible = true
}

function handleEditClick(item) {
    formDialog.vehicle = item
    formDialog.visible = true
}

async function handleDeleteClick(item) {
    const confirmed = await proxy.$confirm(
        `Are you sure you want to delete vehicle <strong>${item.registrationNumber}</strong>?`,
        { title: 'Confirm' }
    )
    if (!confirmed) return

    try {
        await removeVehicle(item.id)
        refreshDatagrid()
    } catch (error) {
        console.error('Failed to delete vehicle:', error)
    }
}

async function handleFormSubmit(form) {
    const id = formDialog.vehicle ? formDialog.vehicle.id : 0
    try {
        await saveVehicle(id, form)
        formDialog.visible = false
        refreshDatagrid()
    } catch (error) {
        console.error('Failed to save vehicle:', error)
    }
}
</script>
