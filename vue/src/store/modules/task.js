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
        async get({commit}) {
            await api.get('task').then(response => {
                commit('set', response);
            })
        },
        async today({commit}) {
            await api.get('task/today').then(response => {
                commit('set', response);
            })
        },
        async achievement({state}, {id}){
            await api.get('task/achievement/' + id).then(response => {
                if(state.data.some(task => task.id === id)){
                    state.data.splice(state.data.findIndex(task => task.id === response.data.id), 1, response.data)
                }
                this.dispatch('rate/get')
                this.dispatch('event/get')
                this.dispatch('history/get')
            })
        },
        async update(_, {id, data}){
            await api.put('task/' + id, data)
        },
        async date({commit}, {data}){
            await api.post('task/date', data).then(response => {
                commit('set', response);
            })
        },
    },
}