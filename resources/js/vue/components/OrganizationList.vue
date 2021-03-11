<template>
    <div>
        <div v-if="isViewingPersons">
            <PersonsBelongToOrganization :persons="personsBelong" :orgname="orgNameSelected"/>
        </div>
        <div v-else>
            <v-data-table
                dense
                :headers="headers"
                :items="allOrganizations"
                sort-by="calories"
                class="elevation-1"
                :search="search"
            >
                <!-- <v-icon small class="mr-2" @click="editItem(item)">
                mdi-dots-vertical
            </v-icon> -->
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-btn depressed color="success" @click="dialog = true">
                            <v-icon>mdi-plus</v-icon> New Organization
                        </v-btn>
                        <v-spacer></v-spacer>
                        <div style="width: 400px">
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                            </div>
                    </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                small
                                class="mr-2"
                                dark
                                v-bind="attrs"
                                v-on="on"
                                color="black"
                            >
                                mdi-dots-vertical
                            </v-icon>
                        </template>
                        <v-list>
                            <v-list-item @click="viewPersonsBelong(item.id, item.name)">
                                <v-list-item-title style="font-size: 12px">
                                    <v-icon size="14"
                                        >mdi-card-search-outline</v-icon
                                    >
                                    View Persons in {{ item.name }}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="updateOrganization(item)">
                                <v-list-item-title style="font-size: 12px">
                                    <v-icon size="14"
                                        >mdi-briefcase-edit-outline</v-icon
                                    >
                                    Update {{ item.name }}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="deleteOrganization(item.id)">
                                <v-list-item-title style="font-size: 12px">
                                    <v-icon size="14"
                                        >mdi-delete-outline</v-icon
                                    >
                                    Delete {{ item.name }}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
                <template v-slot:no-data> </template>
            </v-data-table>
        </div>
        <v-dialog v-model="dialog" width="500">
            <v-card>
                <v-card-title class="headline primary white--text">
                    {{
                        dialogUpdate
                            ? "Update Organization"
                            : "New Organization"
                    }}
                </v-card-title>

                <v-container>
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-if="dialogUpdate"
                                    label="Organization Name"
                                    v-model="currentOrganization.name"
                                    :rules="nameRules"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    v-else
                                    clearable
                                    label="Organization Name"
                                    v-model="organization.name"
                                    :rules="nameRules"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row style="margin-top: -30px">
                            <v-col cols="12">
                                <v-textarea
                                    v-if="dialogUpdate"
                                    name="input-7-1"
                                    label="Organization Description"
                                    v-model="currentOrganization.description"
                                    :rules="descRules"
                                    required
                                ></v-textarea>
                                <v-textarea
                                    v-else
                                    clearable
                                    name="input-7-1"
                                    label="Organization Description"
                                    v-model="organization.description"
                                    :rules="descRules"
                                    required
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="warning"
                        text
                        @click="
                            [(dialog = false), $refs.form.resetValidation()]
                        "
                    >
                        close
                    </v-btn>
                    <v-btn
                        v-if="dialogUpdate"
                        color="primary"
                        tex
                        @click="onUpdateOrganization"
                    >
                        Save Changes
                    </v-btn>
                    <v-btn
                        v-else
                        color="primary"
                        tex
                        @click="createOrganization"
                    >
                        Save Changesss
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import PersonsBelongToOrganization from "./PersonsBelongsToOrg";
export default {
    components: {
        PersonsBelongToOrganization
    },
    data: () => ({
        valid: true,
        dialog: false,
        dialogUpdate: false,
        dialogDelete: false,
        search: "",
        nameRules: [
            v => !!v || "Name is required"
            /* v => (v && v.length <= 10) || 'Name must be less than 10 characters', */
        ],
        descRules: [
            v => !!v || "Description is required",
            v =>
                (v && v.length <= 200) ||
                "Name must be less than 200 characters"
        ],
        headers: [
            {
                text: "Organization Name",
                align: "start",
                sortable: true,
                value: "name"
            },
            { text: "Organization Description", value: "description" },
            { text: "Actions", value: "actions", sortable: false }
        ],
        organization: {
            name: "",
            description: "",
            person_count: 0
        },
        currentOrganization: {},
        editedIndex: -1,
        isViewingPersons: false,
        personsBelong: [],
        orgNameSelected: '',
    }),
    computed: mapGetters(["allOrganizations"]),
    /*  computed: {
        ...mapGetters(['allOrganizations']),
        formTitle() {
            return this.editedIndex === -1 ? "New Item" : "Edit Item";
        },
    }, */

    created() {
        this.fetchOrganizations();
    },

    methods: {
        ...mapActions([
            "fetchOrganizations",
            "addOrganization",
            "deleteOrg",
            "updateOrg",
            "fetchPersonsBelong"
        ]),
        viewPersonsBelong(orgId, orgName) {
            this.isViewingPersons = true;
            /* this.fetchPersonsBelong(orgId); */
            axios.get(`api/organizationsBelong/${orgId}`)
            .then(response => {
                this.personsBelong = response.data
                this.orgNameSelected = orgName
            })
            .catch(error => {
                console.error(error)
            })
        },
        goBack() {
            this.isViewingPersons = false
        },
        createOrganization() {
            if (
                this.organization.name !== "" &&
                this.organization.description !== ""
            ) {
                this.addOrganization(this.organization);
                this.dialog = false;
                this.$swal(
                    "Added Successfully!",
                    `New Organization  ${this.organization.name} Added!`,
                    "success"
                );
                this.$refs.form.reset();
            } else {
                this.$refs.form.validate();
            }
        },
        updateOrganization(item) {
            this.dialogUpdate = true;
            this.currentOrganization = item;
            this.dialog = true;
        },
        onUpdateOrganization() {
            if (
                this.currentOrganization.name !== "" &&
                this.currentOrganization.description !== ""
            ) {
                this.updateOrg(this.currentOrganization);
                this.$swal(
                    "Update Successfully!",
                    `Organization  ${this.organization.name} Updated!`,
                    "success"
                );
                this.$refs.form.reset();
                this.dialog = false;
                this.dialogUpdate = false;
            } else {
                this.$refs.form.validate();
            }
        },
        deleteOrganization(id) {
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.isConfirmed) {
                    this.deleteOrg(id);
                    this.$swal(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                }
            });
        }
    }
};
</script>
