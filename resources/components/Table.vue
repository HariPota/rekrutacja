<template>
    <section class="v-datagrid">
        <v-data-table
            :class="['v-datagrid__table', { 'v-datagrid__table--hover': hoverRows }]"
            :loading="fetching"
            :headers="tableHeaders"
            :items="tableData"
            :items-per-page="itemsPerPage"
            :footer-props="{ itemsPerPageOptions: paginationPageSizes }"
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
        responseKey: {
            type: String,
            default: 'results',
        },
        itemsPerPage: {
            type: Number,
            default: 10,
        },
        paginationPageSizes: {
            type: Array,
            default: () => [5, 10, 25],
        },
        hoverRows: {
            type: Boolean,
            default: true,
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
        async fetchData() {
            if (this.fetching) return

            this.fetching = true
            this.$emit('fetching')

            try {
                let params = {}
                if (this.query) {
                    params = Object.assign({}, this.query)
                }

                const { data } = await axios.get(this.url, { params })
                this.tableData = data[this.responseKey] || data
                this.$emit('fetched', data)
            } catch (error) {
                this.fetchError = 'An error occurred. Please try again.'
                this.$emit('fetchError', error)
            } finally {
                this.fetching = false
            }
        },
    },
    watch: {
        query: {
            deep: true,
            handler() {
                if (this.autoRefresh) {
                    this.refresh()
                }
            },
        },
    },
}
</script>
