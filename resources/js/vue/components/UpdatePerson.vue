<template>
    <v-dialog v-model="dialog" width="550">
        <v-card>
            <v-card-title class="headline primary white--text">
                Update Person
            </v-card-title>
            <v-container>
                <v-form ref="form2" v-model="valid" lazy-validation>
                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                label="First Name"
                                v-model="currentPerson.fname"
                                :rules="[v => !!v || 'FIrst Name is required']"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                label="Middle Name"
                                v-model="currentPerson.mname"
                                :rules="[v => !!v || 'Middle Name is required']"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                name="input-7-1"
                                label="Last Name"
                                v-model="currentPerson.lname"
                                :rules="[v => !!v || 'Last Name is required']"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row style="margin-top: -30px">
                        <v-col cols="12">
                            <v-text-field
                                name="input-7-1"
                                label="Email"
                                v-model="currentPerson.email"
                                :rules="emailRules"
                                required
                            ></v-text-field>
                            <v-text-field
                                name="input-7-1"
                                label="Contact"
                                v-model="currentPerson.contact"
                                :rules="[v => !!v || 'Contact is required']"
                                required
                            ></v-text-field>
                            <v-text-field
                                name="input-7-1"
                                label="Address"
                                v-model="currentPerson.address"
                                :rules="[v => !!v || 'Address is required']"
                                required
                            ></v-text-field>
                            <v-select
                                v-model="currentPerson.organizations"
                                :items="organizations"
                                item-text="name"
                                item-value="id"
                                chips
                                label="Select Organizations"
                                multiple
                                :rules="[v => !!v || 'Organization is required']"
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
                                        (+{{
                                            currentPerson.organizations.length -
                                                1
                                        }}
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
                    @click="[(dialog = false), $refs.form2.resetValidation(), $parent.updating = false]"
                >
                    Cancel
                </v-btn>
                <v-btn color="primary" tex @click="onUpdatePerson">
                    Save Changesss
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapActions } from "vuex";
export default {
    props: ["organizations"],
    data: () => ({
        valid: true,
        select: null,
        dialog: false,
        emailRules: [
            v => !!v || "E-mail is required",
            v => /.+@.+\..+/.test(v) || "E-mail must be valid"
        ],
        currentPerson: {}
    }),
    mounted() {
        this.$root.$on("updateFromPersonsBelong", item => {
            // your code goes here
            this.openDialog(item);
        });
    },
    methods: {
        ...mapActions(["updatePrsn"]),
        openDialog(item) {
            this.dialog = true;
            this.currentPerson = item;
        },
        onUpdatePerson() {
            this.$parent.updating = false
            if (
                this.currentPerson.fname !== "" &&
                this.currentPerson.mname !== "" &&
                this.currentPerson !== "" &&
                this.currentPerson.email !== "" &&
                this.currentPerson.contact !== "" &&
                this.currentPerson.aaddress !== "" &&
                this.currentPerson.organizations.length > 0
            ) {
                this.updatePrsn(this.currentPerson);
                this.dialog = false;
                this.$swal(
                    "Update Successfully!",
                    `Person  ${this.currentPerson.fname} Updated!`,
                    "success"
                );
                this.$refs.form2.reset();
            } else {
                this.$refs.form2.validate();
            }
        }
    }
};
</script>
