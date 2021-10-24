let actions = {
    createCampaign({ commit }, payload) {
        return new Promise((resolve, reject) => {
            axios.post("/api/campaigns", payload.data)
                .then((response) => {
                    commit('CREATE_CAMPAIGN', response.data.data)
                    resolve(response)
                })
                .catch((error) => { reject(error) })
        })
    },
    updateCampaign({ commit }, payload) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/campaigns/${payload.id}`, payload.data)
                .then((response) => {
                    commit('SET_CAMPAIGN', response.data.data)
                    resolve(response)
                })
                .catch((error) => { reject(error) })
        })
    },
    fetchCampaigns({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get("/api/campaigns")
                .then((response) => {
                    commit('SET_CAMPAIGNS', response.data.data)
                    resolve(response)
                })
                .catch((error) => { reject(error) })
        })
    },
    deleteCampaign({ commit }, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`/api/campaigns/${id}`)
                .then((response) => {
                    commit('DELETE_CAMPAIGN', id)
                    resolve(response)
                })
                .catch((error) => { reject(error) })
        })
    },
}

export default actions