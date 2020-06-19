<template>
    <v-card>
        <v-card-title>
            {{page}}
            <v-spacer></v-spacer>
            <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
            ></v-text-field>
        </v-card-title>

        <v-card-text>

            <v-data-table
                    v-model="selected"
                    :headers="headers"
                    :items="users"
                    :single-select="singleSelect"
                    :search="search"
                    item-key="name"
                    show-select
                    class="elevation-1"
            >
                <template v-slot:top>
                    <v-switch v-model="singleSelect" label="Single select" class="pa-3"></v-switch>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>
<script>
    export default {
        name: 'LVBDataTable',
        props: {
            headers: {},
            page: {},
            search: {},
            selected: {},
            singleSelect: {},
            users: {}
        }
    }
</script>
