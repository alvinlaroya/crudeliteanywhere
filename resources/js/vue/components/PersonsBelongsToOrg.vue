<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="persons"
            class="elevation-1"
            :search="search"    
            item-key="id"
        >
            <!-- <v-icon small class="mr-2" @click="editItem(item)">
                mdi-dots-vertical
            </v-icon> -->
            <template v-slot:top>
                <v-toolbar flat>
                    <v-btn depressed color="success" @click="backToOrgTable()" style="margin-right: 20px">
                        <v-icon style="margin-right: 10px">mdi-arrow-left</v-icon> Backs
                    </v-btn>
                    <h4>{{orgname}}</h4>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
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
                        <v-list-item
                            @click="openUpdateDialog(item)"
                        >
                            <v-list-item-title style="font-size: 12px">
                                <v-icon size="15">mdi-account-edit-outline</v-icon> Update {{ item.fname }} {{ item.lname }}
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item
                            @click="deletePerson(item.id)"
                        >
                            <v-list-item-title style="font-size: 12px">
                                <v-icon size="15">mdi-account-cancel-outline</v-icon> Delete {{ item.fname }} {{ item.lname }}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </template>
            <template v-slot:no-data> </template>
        </v-data-table>
        <!-- <AddPerson ref="addPersonComponent" :organizations="allOrganizations"/>
        <UpdatePerson ref="updatePersonComponent" /> -->
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import AddPerson from './AddPerson'
import UpdatePerson from './UpdatePerson'
export default {
    components: {
        AddPerson,
        UpdatePerson
    },
    props: ['persons', 'orgname'],
    data: () => ({
        valid: true,
        search: '',
        expanded: [],
        singleExpand: true,
        textRules: [
            v => !!v || 'Name is required',
            /* v => (v && v.length <= 10) || 'Name must be less than 10 characters', */
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        headers: [
            {
                text: "First Name",
                align: "start",
                sortable: false,
                value: "fname"
            },
            { text: "Middle Name", value: "mname" },
            { text: "Last Name", value: "lname" },
            { text: "Email", value: "email" },
            { text: "Contact", value: "contact" },
            { text: "Address", value: "address" },
            { text: "Actions", value: "actions", sortable: false },
            { text: '', value: 'data-table-expand' },
        ],
        person: {
            fname: '',
            mname: '',
            lname: '',
            email: '',
            contact: '',
            address: '',
        },
        currentPerson: {},
    }),
    /*  computed: {
        ...mapGetters(['allOrganizations']),
        formTitle() {
            return this.editedIndex === -1 ? "New Item" : "Edit Item";
        },
    }, */

    created() {
        //
    },
    methods: {
        ...mapActions(['deletePrsn']),
        openAddDialog() {
            this.$refs.addPersonComponent.openDialog();
        },
        openUpdateDialog(item) {
            this.$root.$emit('updateFromPersonsBelong', item) //like this
        },
        backToOrgTable() {
            this.$parent.goBack();
        },
        deletePerson(id) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.deletePrsn(id)
                this.$swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                this.$parent.goBack();
            }
            })
        }
    }
};
</script>
