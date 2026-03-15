<template>
    <section class="v-datagrid">
        <v-alert v-if="fetchError" type="error" dismissible @input="fetchError = null" class="mb-2">
            {{ fetchError }}
        </v-alert>
        <v-data-table
            :class="['v-datagrid__table', { 'v-datagrid__table--hover': hoverRows }]"
            :loading="fetching"
            :headers="tableHeaders"
            :items="tableData"
            :items-per-page="itemsPerPage"
            :footer-props="{ itemsPerPageOptions: paginationPageSizes }"
            :height="height"
            fixed-header
        >
            <template v-slot:no-results>
                <div class="pa-2">
                    <p>No results found.</p>
                    <v-btn color="primary" small @click="refresh">Refresh</v-btn>
                </div>
            </template>
            <template v-slot:no-data>
                <div class="pa-2">
                    <p>No data available.</p>
                    <v-btn color="primary" small @click="refresh">Refresh</v-btn>
                </div>
            </template>
            <template v-for="(_, name) in $scopedSlots" v-slot:[name]="slotData">
                <slot :name="name" v-bind="slotData" />
            </template>
        </v-data-table>
    </section>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    tableHeaders: { type: Array, required: true },
    url: { type: String, default: '' },
    itemsPerPage: { type: Number, default: 10 },
    paginationPageSizes: { type: Array, default: () => [10, 20, 50] },
    hoverRows: { type: Boolean, default: true },
    height: { type: [String, Number], default: '70vh' },
    autoRefresh: { type: Boolean, default: true },
    query: { type: Object, default: null },
})

const emit = defineEmits(['fetching', 'fetched', 'fetchError'])

const fetching = ref(false)
const fetchError = ref(null)
const tableData = ref([])

const fetchData = async () => {
    if (fetching.value) return

    fetching.value = true
    emit('fetching')

    try {
        const params = props.query ? { ...props.query } : {}
        const { data } = await axios.get(props.url, { params })
        fetchError.value = null
        tableData.value = Array.isArray(data) ? data : (data.rows || [])
        emit('fetched', data)
    } catch (error) {
        fetchError.value = 'An error occurred. Please try again.'
        emit('fetchError', error)
    } finally {
        fetching.value = false
    }
}

const refresh = async () => {
    await fetchData()
}

watch(() => props.query, () => {
    if (props.autoRefresh) {
        refresh()
    }
}, { deep: true })

onMounted(async () => {
    if (!props.url) return

    try {
        await fetchData()
    } catch (error) {
        console.error(error)
    }
})

defineExpose({ refresh })
</script>
