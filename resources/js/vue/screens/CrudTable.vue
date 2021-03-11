<template>
    <v-app class="grey lighten-4">
        <v-container>
            <v-row lign="center" justify="center">
                <v-col cols="12">
                    <v-card>
                        <v-toolbar color="primary" dark flat>
                            <v-app-bar-nav-icon></v-app-bar-nav-icon>

                            <v-toolbar-title
                                >Person & Organization CRUD</v-toolbar-title
                            >

                            <v-spacer></v-spacer>
                            <template v-slot:extension>
                                <v-tabs v-model="tab" align-with-title>
                                    <v-tabs-slider
                                        color="yellow"
                                    ></v-tabs-slider>

                                    <v-tab>
                                        Persons
                                    </v-tab>
                                    <v-tab>
                                        Organizations
                                    </v-tab>
                                </v-tabs>
                            </template>
                        </v-toolbar>

                        <v-tabs-items v-model="tab">
                            <v-tab-item>
                                <v-card flat>
                                    <PersonList />
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <OrganizationList />
                                </v-card>
                            </v-tab-item>
                        </v-tabs-items>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import OrganizationList from '../components/OrganizationList'
import PersonList from '../components/PersonList'
export default {
    components: {
        OrganizationList,
        PersonList
    },
    data: () => ({
        tab: null
    })
}
</script>
