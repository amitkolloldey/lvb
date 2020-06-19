<template>
    <v-app-bar
            :clipped-left="primaryDrawer.clipped"
            app
            flat
            dense
            color="indigo"
    >
        <v-app-bar-nav-icon
                v-if="primaryDrawer.type !== 'permanent'"
                @click.stop="primaryDrawer.model = !primaryDrawer.model"
                class="white--text"></v-app-bar-nav-icon>
        <v-toolbar-title class="white--text">LVB</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon to="af">
            <v-icon class="white--text">mdi-home</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon class="white--text">mdi-export</v-icon>
        </v-btn>
    </v-app-bar>
</template>
<script>
    export default {
        name: 'HeaderBar',
        props: {
            primaryDrawer: {}
        }
    }
</script>
