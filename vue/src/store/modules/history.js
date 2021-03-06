import api from '@/libs/api'

export default {
    namespaced:true,
    state: {
        data: [],
    },
    mutations: {
        set: (state, response) => {
            state.data = response.data;
        },
    },
    getters: {
    },
    actions: {
        async get({commit}){
            await api.get('task/histories').then(response => {
                commit('set', response);
            })
        },
    },
}