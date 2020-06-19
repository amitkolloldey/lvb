<template>
    <div>

        <!-- Datatable List -->
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
                        :search="search"
                        item-key="id"
                        show-select
                        loading="true"
                        class="elevation-1"
                    >
                        <template v-slot:item.name="{ item }">
                            <img v-bind:src="item.gravatar_url" class="rounded rounded-circle" width="30"/>
                            {{item.name}}
                        </template>
                        <template v-slot:item.email="{ item }">
                            {{item.email}}
                        </template>
                        <template v-slot:item.role="{ item }">
                            <span v-if="item.role.name">{{item.role.label}}</span>
                            <span v-else>None</span>
                        </template>
                        <template v-slot:item.email_verified_at="{ item }">
                            <v-badge bordered color="error" content="Not Verified" v-if="item.email_verified_at === null"></v-badge>
                            <v-badge bordered color="success" content="Verified" v-else></v-badge>
                        </template>
                        <template v-slot:item.status="{ item }">
                            <v-badge bordered color="success" content="Active" v-if="item.status === 1"></v-badge>
                            <v-badge bordered color="error" content="Not Active" v-else></v-badge>
                        </template>
                        <template v-slot:item.created_updated_at="{ item }">
                                <span>
                                    {{item.created_at}}
                                </span>
                            <span> / </span>
                            <span>
                                    {{item.updated_at}}
                                </span>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn class="ma-2" outlined x-small fab color="indigo" @click="showEditModal(item)">
                                <v-icon small>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn class="ma-2" outlined x-small fab color="red"
                                   @click="deleteItem(item.id, false)">
                                <v-icon small>mdi-delete</v-icon>
                            </v-btn>
                        </template>
                        <template v-slot:top>
                            <v-btn class="ma-2" small tile outlined color="error">
                                <v-icon left small>mdi-delete</v-icon>
                                Move to Trash
                            </v-btn>
                            <v-btn class="ma-2" small tile outlined color="info">
                                <v-icon left small>mdi-backup-restore</v-icon>
                                Restore From Trash
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </template>
        <!-- End Datatable List -->

        <!-- Add New Modal -->
        <template>
            <v-row justify="center">
                <v-dialog v-model="addModal" fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar dark color="indigo" dense flat tile>
                            <v-toolbar-title>Add New Item</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn dark text @click="addModal = false">Close</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <div class="col-md-12">
                            <v-card class="pa-5">
                                <v-form
                                    ref="form"
                                    v-model="valid"
                                    lazy-validation
                                >
                                    <v-text-field
                                        v-model="form_data.name"
                                        :counter="20"
                                        :rules="nameRules"
                                        label="Name"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="form_data.email"
                                        :rules="emailRules"
                                        label="E-mail"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="form_data.password"
                                        hint="At least 8 characters"
                                        label="Password"
                                        :type="'password'"
                                        :rules="passwordRules"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="form_data.password_confirmation"
                                        label="Confirm Password"
                                        :type="'password'"
                                        :rules="confirmPasswordRules"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-select
                                        v-model="form_data.role"
                                        :items="roles"
                                        label="Roles"
                                        item-text="name"
                                        item-value="id"
                                        :rules="roleRules"
                                        outlined
                                        shaped
                                    >
                                    </v-select>
                                    <v-switch
                                        v-model="form_data.status"
                                        :label="`Status`"
                                    ></v-switch>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        class="ma-2"
                                        :loading="loading"
                                        :disabled="disabled"
                                        color="info"
                                        @click="addItem"
                                    >
                                        Save
                                        <template v-slot:loader>
                                            <span class="custom-loader">
                                              <v-icon light class="white--text">mdi-loading</v-icon>
                                            </span>
                                        </template>
                                    </v-btn>
                                </v-form>
                            </v-card>
                        </div>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>
        <!-- End Add Modal -->

        <!-- Edit Modal -->
        <template>
            <v-row justify="center">
                <v-dialog v-model="editModal" fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar dark color="indigo" dense flat tile>
                            <v-toolbar-title>Edit Item</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn dark text @click="editModal = false">Close</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <div class="col-md-12">
                            <v-card class="pa-5">
                                <v-form
                                    ref="form"
                                    v-model="editValid"
                                    lazy-validation
                                >
                                    <v-text-field
                                        v-model="added_form_data.name"
                                        :counter="20"
                                        :rules="nameRules"
                                        label="Name"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="added_form_data.email"
                                        label="E-mail"
                                        required
                                        shaped
                                        outlined
                                        disabled
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="added_form_data.password"
                                        hint="At least 8 characters. Leave Black If You Do Want To Change Password."
                                        label="Password"
                                        :type="'password'"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="added_form_data.password_confirmation"
                                        hint="Leave Black If You Do Want To Change Password."
                                        label="Confirm Password."
                                        :type="'password'"
                                        :rules="editConfirmPasswordRules"
                                        required
                                        shaped
                                        outlined
                                    ></v-text-field>
                                    <v-select
                                        v-model="added_form_data.role"
                                        :items="roles"
                                        label="Roles"
                                        item-text="name"
                                        item-value="id"
                                        outlined
                                        shaped
                                    >
                                    </v-select>
                                    <v-switch
                                        v-model="added_form_data.status"
                                        :label="`Status`"
                                    ></v-switch>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        class="ma-2"
                                        :loading="editLoading"
                                        :disabled="editDisabled"
                                        color="info"
                                        @click="editItem(added_form_data.id)"
                                    >
                                        Update
                                        <template v-slot:loader>
                                            <span class="custom-loader">
                                              <v-icon light class="white--text">mdi-loading</v-icon>
                                            </span>
                                        </template>
                                    </v-btn>
                                </v-form>
                            </v-card>
                        </div>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>
        <!-- End Edit Modal -->

        <!-- Delete Modal -->
        <template>
            <v-row justify="center">
                <v-dialog v-model="deleteModal" persistent max-width="290" dark>
                    <v-card>
                        <v-card-title class="headline">Are You Sure Want To Delete?</v-card-title>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green" @click="deleteModal = false" small>
                                <v-icon left small>mdi-backup-restore</v-icon>
                                No
                            </v-btn>
                            <v-btn color="error" @click="deleteItem(deleteItemId, true)" small>
                                <v-icon left small>mdi-delete</v-icon>
                                Delete
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>
        <!-- End Delete Modal -->

        <!-- Floating Alert  -->
        <template>
            <v-snackbar
                v-model="snackbar"
                :color="snackbarColor"
                :right="'right'"
                :top="'top'"
                shaped
            >
                {{ snackbarText }}
            </v-snackbar>
        </template>
        <!-- End Floating Alert -->

        <!-- Add New Floating Button -->
        <template>
            <v-btn
                v-show="!hidden"
                color="green"
                dark
                fixed
                bottom
                right
                fab
                @click="addModal = true"
            >
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>
        <!-- End Floating Button -->

    </div>
</template>

<script>

    export default {
        data() {
            return {
                // Validation Rules
                nameRules: [
                    value => !!value || 'Name is required',
                    value => (value && value.length <= 20) || 'Name must be less than 20 characters',
                ],
                emailRules: [
                    value => !!value || 'E-mail is required',
                    value => /.+@.+\..+/.test(value) || 'E-mail must be valid',
                ],
                roleRules: [
                    value => !!value || 'Role is required',
                ],
                passwordRules: [
                    value => !!value || 'Password is required.',
                    value => value.length >= 8 || 'Min 8 characters'
                ],
                confirmPasswordRules: [
                    value => !!value || 'Confirm Password is required.',
                    value => (value === this.form_data.password) || 'Password did not Match'
                ],
                editConfirmPasswordRules: [
                    value => (value === this.added_form_data.password) || 'Password did not Match'
                ],

                // Data For Add Form
                form_data: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    status: true,
                    role: ''
                },

                // Data For Edit Form
                added_form_data: {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    status: '',
                    role: ''
                },

                // Data For Delete
                deleteItemId: '',

                page: 'Pages', // Page Name
                search: '', // Datatable Search
                hidden: false, // Floating Button
                selected: [], // Datatable Checked Entries
                addModal: false, // Modal is Hidden By Default
                editModal: false, // Modal is Hidden By Default
                deleteModal: false, // Modal is Hidden By Default
                valid: true, // Default Add Form State
                editValid: true, // Default Edit Form State
                snackbar: false, // Alert Disabled
                snackbarText: '', // Alert Text
                snackbarColor: '', // Alert Color
                loading: false, // Save Button Loading
                disabled: false, // Save Button Disabled
                editLoading: false, // Update Button Loading
                editDisabled: false, // Update Button Disabled

                // Datatable Headers
                headers: [
                    {text: 'Id', align: ' d-none', sortable: false, value: 'id'},
                    {text: 'Name', sortable: true, value: 'name'},
                    {text: 'Email', value: 'email'},
                    {text: 'Role', value: 'role', sortable: true},
                    {text: 'Email Verified', value: 'email_verified_at'},
                    {text: 'Status', value: 'status'},
                    {text: 'Created At / Updated At', value: 'created_updated_at'},
                    {text: 'Action', value: 'actions'}
                ],

                // Datatable Entries
                users: [],

                // RoleResource Array
                roles: [],
            }
        },

        methods: {
            // Adding Item
            async addItem() {
                this.loading = true
                this.disabled = true

                // Form Field Validation
                const validator = this.$refs.form.validate()
                if (validator) {
                    // Sending Post Request
                    const response = await this.lvbCallApi('post', '/api/user/store', this.form_data)

                    // If Any Error Occurs
                    if (response.status !== 201) {
                        this.snackbarText = ''+ Object.values(response.data.validation)[0] +'' // One error at a time
                        this.snackbarColor = "error"
                        this.snackbar = true
                        this.loading = false
                        this.disabled = false
                    } else { // Success
                        this.snackbarText = response.data.success
                        this.snackbarColor = "success"
                        this.snackbar = true
                        this.addModal = false
                        this.$refs.form.reset()
                        this.loading = false
                        this.disabled = false
                        this.form_data.status = true
                        window.location.reload()
                    }
                } else {
                    this.loading = false
                    this.disabled = false
                }
            },

            // Shows Edit Modal and Particular Item Data
            async showEditModal(item) {
                this.editModal = true
                this.added_form_data.id = item.id
                this.added_form_data.name = item.name
                this.added_form_data.email = item.email
                this.added_form_data.role = item.role
                this.added_form_data.status = item.status
            },

            // Deleting the Item
            async deleteItem(id, confirm) {
                this.deleteItemId = id
                this.deleteModal = true
                if (confirm) {
                    // Sending Delete Request
                    const response = await this.lvbCallApi('delete', '/api/user/destroy/' + id)
                    // If Any Error Occurs
                    if (response.status !== 201) {
                        this.snackbarText = "Something Went Wrong!"
                        this.snackbarColor = "error"
                        this.snackbar = true
                    } else { // Success
                        this.deleteModal = false
                        this.snackbarText = response.data.success
                        this.snackbarColor = "success"
                        this.snackbar = true
                        window.location.reload()
                    }
                }
            },

            // Editing Item
            async editItem(id) {
                this.editLoading = true
                this.editDisabled = true

                // Form Field Validation
                const validator = this.$refs.form.validate()
                if (validator) {
                    // Sending Post Request
                    const response = await this.lvbCallApi('put', '/api/user/update/' + id, this.added_form_data)

                    // If Any Error Occurs
                    if (response.status !== 201) {
                        console.log(response.data)
                        this.snackbarText = ''+ Object.values(response.data.validation)[0] +'' // One error at a time
                        this.snackbarColor = "error"
                        this.snackbar = true
                        this.editLoading = false
                        this.editDisabled = false
                    } else { // Success
                        this.snackbarText = response.data.success
                        this.snackbarColor = "success"
                        this.snackbar = true
                        this.editModal = false
                        this.$refs.form.reset()
                        this.editLoading = false
                        this.editDisabled = false
                        this.form_data.status = true
                        window.location.reload()
                    }
                }
            },
        },

        async created() {
            // Getting Item Lists for The Table and For Create/Edit Form
            const response = await this.lvbCallApi('get', '/api/get/users')

            // If Success Setting Users Array
            if (response.status === 200) {
                this.users = response.data.data
                this.roles = response.data.roles
                console.log(this.users)
            } else { // If any Error Occurs
                this.snackbarText = "Something Went Wrong!"
                this.snackbarColor = "error"
                this.snackbar = true
            }
        },
    }
</script>
