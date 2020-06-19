<template>
    <v-navigation-drawer
        v-model="primaryDrawer.model"
        :clipped="primaryDrawer.clipped"
        :floating="primaryDrawer.floating"
        :mini-variant="primaryDrawer.mini"
        :permanent="primaryDrawer.type === 'permanent'"
        :temporary="primaryDrawer.type === 'temporary'"
        app
        overflow
    >
        <template v-slot:prepend>
            <v-list-item two-line>
                <v-list-item-avatar>
                    <img src="https://randomuser.me/api/portraits/women/81.jpg">
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>Amit</v-list-item-title>
                    <v-list-item-subtitle>Logged In</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </template>

        <v-divider></v-divider>
        <v-list dense>

            <router-link to="/admin/dashboard">
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </router-link>
            <v-divider></v-divider>


            <v-list-group value="true">
                <template v-slot:activator>
                    <v-list-item-action>
                        <v-icon>mdi-account-group</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>User Management</v-list-item-title>
                    </v-list-item-content>
                </template>

                <router-link to="/admin/users">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-account</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Users</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>

                <router-link to="/admin/roles">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-account-box-multiple-outline</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Roles</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>

                <router-link to="/admin/permissions">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-account-key-outline</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Permissions</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>
            </v-list-group>
            <v-divider></v-divider>


            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-action>
                        <v-icon>mdi-monitor-edit</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>CMS</v-list-item-title>
                    </v-list-item-content>
                </template>

                <router-link to="/admin/pages">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-account-box-multiple-outline</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Pages</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>

                <router-link to="/admin/posts">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-account-key-outline</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Posts</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>

                <router-link to="/admin/categories">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-clipboard-text-multiple</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Categories</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>
            </v-list-group>
            <v-divider></v-divider>


            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-action>
                        <v-icon>mdi-cog-outline</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title color="white">Settings</v-list-item-title>
                    </v-list-item-content>
                </template>

                <router-link to="/admin/general-settings">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-table-cog</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>General Settings</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>
            </v-list-group>
            <v-divider></v-divider>


            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-action>
                        <v-icon>mdi-email-newsletter</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Messages</v-list-item-title>
                    </v-list-item-content>
                </template>

                <router-link to="/admin/contact-messages">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-email-multiple</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Contact Messages</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>
            </v-list-group>
            <v-divider></v-divider>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-action>
                        <v-icon>mdi-folder-open</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Media</v-list-item-title>
                    </v-list-item-content>
                </template>

                <router-link to="/admin/files">
                    <v-list-item link>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-folder-multiple</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Files</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item>
                </router-link>
            </v-list-group>
            <v-divider></v-divider>
        </v-list>
    </v-navigation-drawer>
</template>
<script>
    export default {
        name: 'Sidebar',
        props: {
            primaryDrawer: {}
        }
    }
</script>
