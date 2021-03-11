import axios from 'axios';


const state = {
    organizations: [],
    personsBelong: []
};

const getters = {
    allOrganizations: state => state.organizations,
    allPersonsBelong: state => state.personsBelong,
};




const actions = {
    async fetchPersonsBelong({commit}, orgId) {
        axios.get(`api/organizationsBelong/${orgId}`)
        .then(response => {
            commit('setPersonsBelong', response.data);
        })
        .catch(error => {
            console.error(error)
        })
    },
    async fetchOrganizations({commit}) {
        axios.get('api/organizations')
        .then(response => {
            commit('setOrganizations', response.data);
        })
        .catch(error => {
            console.error(error)
        })
    },
    async addOrganization( { commit }, organization) {
        axios.post('api/organization/store', {
            item: organization
        })
        .then(response => {
            if(response.status == 201) {
                commit('newOrganization', response.data);
            }
        })
        .catch(error => {
            console.error(error)
        })
    },
    async deleteOrg({commit}, id) {
        axios.delete(`api/organization/${id}`)
        .then(response => {
            if(response.status == 200) {
                commit('deleteOrganization', response.data);
            }
        })
        .catch(error => {
            console.error(error)
        })
    },
    async updateOrg( { commit }, organization) {
        axios.put(`api/organization/${organization.id}`, {
            item: {
                name: organization.name,
                description: organization.description
            }
        })
        .then(response => {
            if(response.status == 200) {
                commit('updateOrganization', response.data);
            }
        })
        .catch(error => {
            console.error(error)
        })
    },
};

const mutations = {
    setPersonsBelong: (state, persons) => {
        state.personsBelong = persons
    },
    setOrganizations: (state, organizations) => {
        state.organizations = organizations
    },
    newOrganization: (state, organization) => {
        state.organizations.push(organization)
    },
    updateOrganization: (state, updateOrganization) => {
        const index = state.organizations.findIndex(org => org.id === updateOrganization.id);
        if(index !== -1) {
            state.organizations.splice(index, 1, updateOrganization);
        }
    },
    
    deleteOrganization: (state, organization) => {
        state.organizations = state.organizations.filter(o => organization.id !== o.id)
    },
};

export default {
    state, getters, actions, mutations
}