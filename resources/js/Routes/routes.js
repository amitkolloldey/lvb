import Vue from "vue"
import VueRouter from "vue-router"
import dashboard from "../components/admin/pages/Dashboard"
import users from "../components/admin/pages/Users"
import roles from "../components/admin/pages/Roles"
import permissions from "../components/admin/pages/Permissions"
import pages from "../components/admin/pages/Pages"
import posts from "../components/admin/pages/Posts"
import categories from "../components/admin/pages/Categories"
import generalsettings from "../components/admin/pages/GeneralSettings"
import contactmessages from "../components/admin/pages/ContactMessages"
import files from "../components/admin/pages/Files"

Vue.use(VueRouter)


// Admin Routes
const routes = [
    {
        path: '/admin/',
        component: dashboard
    },
    {
        path: '/admin/dashboard',
        component: dashboard
    },
    {
        path: '/admin/users',
        component: users
    },
    {
        path: '/admin/roles',
        component: roles
    },
    {
        path: '/admin/permissions',
        component: permissions
    },
    {
        path: '/admin/pages',
        component: pages
    },
    {
        path: '/admin/posts',
        component: posts
    },
    {
        path: '/admin/categories',
        component: categories
    },
    {
        path: '/admin/general-settings',
        component: generalsettings
    },
    {
        path: '/admin/contact-messages',
        component: contactmessages
    },
    {
        path: '/admin/files',
        component: files
    },
]

export default new VueRouter({
    mode: 'history',
    routes
})
