<template>
  <div class="container mt-4">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">From</th>
          <th scope="col">To</th>
          <th scope="col">Daily Budget (USD)</th>
          <th scope="col">Total Budget (USD)</th>
          <th scope="col">Creatives</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
          <th scope="col">Created At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(campaign, i) in campaigns" :key="i">
          <th scope="row">{{ campaign.id }}</th>
          <td>{{ campaign.name }}</td>
          <td>{{ campaign.from }}</td>
          <td>{{ campaign.to }}</td>
          <td>{{ campaign.daily_budget }}</td>
          <td>{{ campaign.total_budget }}</td>
          <td>
            <button
              @click="previewCreative(campaign)"
              type="button"
              class="btn btn-outline-success"
            >
              View
            </button>
          </td>
          <td>
            <a :href="'/edit/'+campaign.id"
              type="button"
              class="btn btn-outline-info"
            >
              Edit
            </a>
          </td>
          <td>
            <button
              @click="removeCampaign(campaign.id)"
              type="button"
              class="btn btn-outline-danger"
            >
              Delete
            </button>
          </td>
          <td>{{ campaign.created_at }}</td>
        </tr>
      </tbody>
    </table>
    <preview-modal :data="campaign"></preview-modal>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      campaign: {},
    };
  },
  computed: {
    ...mapGetters(["campaigns"]),
  },
  methods: {
    previewCreative(campaign) {
      this.campaign = campaign;
      $("#previewModal").modal("show");
    },
    removeCampaign(id) {
        this.$store.dispatch("deleteCampaign", id)
    }
  },
  mounted() {
    this.$store.dispatch("fetchCampaigns");
  },
};
</script>
<style lang="scss" scoped>
.fs-12 {
  font-size: 12px;
}
.img-container {
  position: relative;
  .cancel {
    position: absolute;
    top: 10px;
    right: 30px;
    cursor: pointer;
    font-size: 30px;
  }
}
.btn.disabled,
.btn:disabled {
  cursor: not-allowed;
}
</style>
