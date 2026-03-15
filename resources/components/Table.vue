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
            :server-items-length="total"
            :options.sync="internalOptions"
            :items-per-page="currentLimit"
            :page.sync="currentPage"
            :footer-props="{ itemsPerPageOptions: paginationPageSizes }"
            :height="height"
            fixed-header
            @update:page="handlePageUpdate"
            @update:items-per-page="handleItemsPerPageChange"
            @update:sort-desc="handleSortChange"
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
            <slot v-for="(_, name) in $slots" :name="name" :slot="name" />
            <template v-for="(_, name) in $scopedSlots" :slot="name" slot-scope="slotData">
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


const initialized = ref(false)
const fetching = ref(false)
const fetchError = ref(null)
const tableData = ref([])
const total = ref(0)
const currentPage = ref(1)
const currentLimit = ref(props.itemsPerPage)
const internalOptions = ref({})


const buildSortString = (sort) => {
    if (!sort || typeof sort !== 'object') return null
    const { field, direction } = sort
    if (!field) return null
    return `${field}|${direction || 'ascending'}`
}

const fetchData = async (overrideParams) => {
    if (fetching.value) return

    fetching.value = true
    emit('fetching')

    try {
        let params = {
            page: currentPage.value,
            limit: currentLimit.value,
        }

        const { sortBy = [], sortDesc = [] } = internalOptions.value
        if (sortBy.length > 0) {
            params.sort = buildSortString({
                field: sortBy[0],
                direction: sortDesc[0] ? 'descending' : 'ascending',
            })
        }

        if (props.query) {
            params = Object.assign({}, props.query, params)
        }

        if (overrideParams) {
            params = Object.assign({}, params, overrideParams)
        }

        const { data } = await axios.get(props.url, { params })
        fetchError.value = null
        tableData.value = data.rows || []
        total.value = data.total || 0
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

const handlePageUpdate = async (page) => {
    currentPage.value = page
    await fetchData()
}

const handleItemsPerPageChange = async (limit) => {
    currentLimit.value = limit
    currentPage.value = 1
    await fetchData()
}

const handleSortChange = async () => {
    currentPage.value = 1
    await fetchData()
}


watch(() => props.query, () => {
    if (props.autoRefresh) {
        currentPage.value = 1
        refresh()
    }
}, { deep: true })


onMounted(async () => {
    if (!props.url) return

    try {
        await fetchData()
        initialized.value = true
    } catch (error) {
        console.error(error)
    }
})

defineExpose({ refresh })
</script>
