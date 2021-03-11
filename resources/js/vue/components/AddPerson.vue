<template>
    <v-dialog v-model="dialog" width="550">
        <v-card>
            <v-card-title class="headline primary white--text">
                New Person
            </v-card-title>

            <v-container style="padding: 20px">
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                clearable
                                label="First Name"
                                v-model="person.fname"
                                :rules="[v => !!v || 'First Name is required']"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                clearable
                                label="Middle Name"
                                v-model="person.mname"
                               :rules="[v => !!v || 'Middle Name is required']"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                clearable
                                name="input-7-1"
                                label="Last Name"
                                v-model="person.lname"
                                :rules="[v => !!v || 'Last Name is required']"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row style="margin-top: -25px">
                        <v-col cols="12">
                            <v-text-field
                                clearable
                                name="input-7-1"
                                label="Email"
                                v-model="person.email"
                                :rules="emailRules"
                                required
                            ></v-text-field>
                            <v-text-field
                                clearable
                                name="input-7-1"
                                label="Contact"
                                v-model="person.contact"
                                :rules="[v => !!v || 'Contact is required']"
                                required
                            ></v-text-field>
                            <v-text-field
                                clearable
                                name="input-7-1"
                                label="Address"
                                v-model="person.address"
                                :rules="[v => !!v || 'Address is required']"
                                required
                            ></v-text-field>
                            <v-select
                                v-model="person.organizations"
                                :items="organizations"
                                item-text="name"
                                item-value="id"
                                chips
                                label="Select Organizations"
                                multiple
                                :rules="[v => !!v || 'Organizations is required']"
                                required
                            >
                                <template v-slot:selection="{ item, index }">
                                    <v-chip v-if="index === 0">
                                        <span>{{ item.name }}</span>
                                    </v-chip>
                                    <span
                                        v-if="index === 1"
                                        class="grey--text caption"
                                    >
                                        (+{{ person.organizations.length - 1 }}
                                        others)
                                    </span>
                                </template>
                            </v-select>
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
                    @click="[(dialog = false), $refs.form.resetValidation(), person.organizations = []]"
                >
                    Cancel
                </v-btn>
                <v-btn color="primary" tex @click="createPerson">
                    Save Changesss
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
    props: ["organizations"],
    data: () => ({
        valid: true,
        dialog: false,
        textRules: [
            v => !!v || "Name is required"
            /* v => (v && v.length <= 10) || 'Name must be less than 10 characters', */
        ],
        emailRules: [
            v => !!v || "E-mail is required",
            v => /.+@.+\..+/.test(v) || "E-mail must be valid"
        ],
        person: {
            fname: "",
            mname: "",
            lname: "",
            email: "",
            contact: "",
            address: "",
            organizations: []
        },
        items: []
    }),
    methods: {
        ...mapActions(["addPerson", "deletePrsn", "updatePrsn"]),
        openDialog() {
            this.dialog = true;
        },
        createPerson() {
            if (
                this.person.fname !== "" &&
                this.person.mname !== "" &&
                this.lname !== "" &&
                this.person.email !== "" &&
                this.person.contact !== "" &&
                this.person.aaddress !== "" &&
                this.person.organizations.length > 0
            ) {
                this.addPerson(this.person);
                this.dialog = false;
                this.$swal(
                    "Added Successfully!",
                    `New Person ${this.person.fname} Added!`,
                    "success"
                );
                this.$refs.form.reset();
            } else {
                this.$refs.form.validate();
            }
        }
    }
};
</script>
