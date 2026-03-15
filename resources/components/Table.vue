<template>
    <section class="v-datagrid">
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

<script>
import axios from 'axios'

function buildSortString(sort) {
    if (!sort || typeof sort !== 'object') return null
    const { field, direction } = sort
    if (!field) return null
    return `${field}|${direction || 'ascending'}`
}

export default {
    name: 'Table',
    props: {
        tableHeaders: {
            type: Array,
            required: true,
        },
        url: {
            type: String,
            default: '',
        },
        itemsPerPage: {
            type: Number,
            default: 10,
        },
        paginationPageSizes: {
            type: Array,
            default: () => [10, 20, 50],
        },
        hoverRows: {
            type: Boolean,
            default: true,
        },
        height: {
            type: [String, Number],
            default: '70vh',
        },
        autoRefresh: {
            type: Boolean,
            default: true,
        },
        query: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            initialized: false,
            fetching: false,
            fetchError: null,
            tableData: [],
            total: 0,
            currentPage: 1,
            currentLimit: this.itemsPerPage,
            internalOptions: {},
        }
    },
    mounted() {
        this.init()
    },
    methods: {
        async init() {
            if (!this.url || this.initialized) return

            try {
                await this.fetchData()
                this.initialized = true
            } catch (error) {
                console.error(error)
            }
        },
        async refresh() {
            await this.fetchData()
        },
        async fetchData(overrideParams) {
            if (this.fetching) return

            this.fetching = true
            this.$emit('fetching')

            try {
                let params = {
                    page: this.currentPage,
                    limit: this.currentLimit,
                }

                const { sortBy = [], sortDesc = [] } = this.internalOptions
                if (sortBy.length > 0) {
                    params.sort = buildSortString({
                        field: sortBy[0],
                        direction: sortDesc[0] ? 'descending' : 'ascending',
                    })
                }

                if (this.query) {
                    params = Object.assign({}, this.query, params)
                }

                if (overrideParams) {
                    params = Object.assign({}, params, overrideParams)
                }

                const { data } = await axios.get(this.url, { params })
                this.tableData = data.rows || []
                this.total = data.total || 0
                this.$emit('fetched', data)
            } catch (error) {
                this.fetchError = 'An error occurred. Please try again.'
                this.$emit('fetchError', error)
            } finally {
                this.fetching = false
            }
        },
        async handlePageUpdate(page) {
            this.currentPage = page
            await this.fetchData()
        },
        async handleItemsPerPageChange(limit) {
            this.currentLimit = limit
            this.currentPage = 1
            await this.fetchData()
        },
        async handleSortChange() {
            this.currentPage = 1
            await this.fetchData()
        },
    },
    watch: {
        query: {
            deep: true,
            handler() {
                if (this.autoRefresh) {
                    this.currentPage = 1
                    this.refresh()
                }
            },
        },
    },
}
</script>
