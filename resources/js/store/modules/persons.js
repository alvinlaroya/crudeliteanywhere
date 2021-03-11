import axios from 'axios';
import store from '../index'

const state = {
    persons: [],
};

const getters = {
    allPersons: state => state.persons
};




const actions = {
    async fetchPersons({commit}) {
        axios.get('api/persons')
        .then(response => {
            commit('setPersons', response.data);
        })
        .catch(error => {
            console.error(error)
        })
    },
    async addPerson( { commit }, person) {
        axios.post('api/person/store', {
            item: person
        })
        .then(response => {
            if(response.status == 200) {
                commit('newPerson', response.data);
                store.dispatch('fetchOrganizations')
            }
        })
        .catch(error => {
            console.error(error)
        })
    },
    async deletePrsn({commit}, id) {
        axios.delete(`api/person/${id}`)
        .then(response => {
            if(response.status == 200) {
                commit('deletePerson', response.data);
                store.dispatch('fetchOrganizations')
            }
        })
        .catch(error => {
            console.error(error)
        })
    },
    async updatePrsn( { commit }, person) {
        axios.put(`api/person/${person.id}`, {
            item: {
                ...person
            }
        })
        .then(response => {
            if(response.status == 200) {
                commit('updatePerson', response.data);
            }
        })
        .catch(error => {
            console.error(error)
        })
    },
};

const mutations = {
    setPersons: (state, persons) => {
        state.persons = persons
    },
    newPerson: (state, person) => {
        state.persons.unshift({
            ...person[0],
            organizations: person[1]
        })

    },
    updatePerson: (state, updatedPerson) => {
        const index = state.persons.findIndex(person => person.id === updatedPerson[0].id);
        /* if(index !== -1) {
            state.persons.splice(index, 1, updatedPerson);
        } */
        let updatedPersonWithOrg = {
            ...updatedPerson[0],
            organizations: updatedPerson[1]
        }
        console.log(updatedPersonWithOrg)
        if(index !== -1) {
            state.persons.splice(index, 1, updatedPersonWithOrg);
        }
    },
    
    deletePerson: (state, person) => {
        state.persons = state.persons.filter(o => person.id !== o.id)
    },
};

export default {
    state, getters, actions, mutations
}