let mutations = {
    CREATE_CAMPAIGN(state, campaign) {
        state.campaigns.unshift(campaign)
    },
    SET_CAMPAIGNS(state, campaigns) {
        state.campaigns = campaigns
    },
    SET_CAMPAIGN(state, campaign) {
        let index = state.campaigns.findIndex(item => item.id === campaign.id)
        if (index !== -1) {
            state.campaigns[index] = campaign
        }
    },
    DELETE_CAMPAIGN(state, id) {
        let index = state.campaigns.findIndex(item => item.id === id)
        state.campaigns.splice(index, 1)
    }

}
export default mutations