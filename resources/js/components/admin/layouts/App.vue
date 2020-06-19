<template>
    <div id="app">
        <v-app id="inspire">
            <Sidebar :primary-drawer="primaryDrawer"/>

            <AppBar :primary-drawer="primaryDrawer"/>

            <v-main>
                <v-container fluid>
                    <v-row
                        align="center"
                        justify="center"
                    >
                        <v-col cols="12">
                            <router-view></router-view>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>

            <FooterBar :footer="footer"/>

        </v-app>
    </div>
</template>

<script>
    import Sidebar from "../partials/SideBar";
    import AppBar from "../partials/HeaderBar";
    import FooterBar from "../partials/FooterBar";

    export default {
        components: {
            FooterBar,
            AppBar,
            Sidebar
        },
        props: {
            source: String,
        },

        data: () => ({
            name: 'Dashboard',
            drawers: ['Default (no property)', 'Permanent', 'Temporary'],
            primaryDrawer: {
                model: null,
                type: 'default (no property)',
                clipped: true,
                floating: false,
                mini: false,
            },
            footer: {
                inset: true,
            },
        }),
        created() {
            this.$vuetify.theme.light = true
        },
    }
</script>
