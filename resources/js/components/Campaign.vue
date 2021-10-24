<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ title }}</div>

          <div class="card-body">
            <form>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    v-model="name"
                  />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="from">From</label>
                  <input
                    type="date"
                    class="form-control"
                    id="from"
                    name="from"
                    v-model="from"
                  />
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="from">To</label>
                  <input
                    type="date"
                    class="form-control"
                    id="to"
                    name="to"
                    v-model="to"
                  />
                </div>
                <div class="col-md-3 mb-3">
                  <label for="dailyBudget">Daily Budget</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="daily_budget"
                    name="dailyBudget"
                    id="dailyBudget"
                  />
                </div>
                <div class="col-md-3 mb-3">
                  <label for="totalBudget">Total Budget</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="total_budget"
                    name="totalBudget"
                    id="totalBudget"
                  />
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="addCreative">Add Creative</label>
                  <input
                    type="file"
                    accept="image/*"
                    ref="imageInput"
                    name="creative"
                    class="form-control"
                    id="addCreative"
                    @change="onChange"
                  />
                  <p v-if="type === 'new'" class="text-muted fs-12 mt-2">
                    Browse and select creative to add.
                  </p>
                  <p v-if="type === 'old'" class="text-muted fs-12 mt-2">
                    By adding new creatives, you'll override the previous
                    uploaded files.
                  </p>
                </div>
              </div>
              <div class="row" v-if="creatives.length">
                <div
                  class="col-md-3 mb-3 img-container"
                  v-for="(banner, i) in creatives"
                  :key="i"
                >
                  <img :src="banner.url" class="img-fluid" />
                  <i
                    class="far fa-times-circle text-danger cancel"
                    @click="removeBanner(i)"
                  ></i>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mb-3" v-if="success.length">
                  <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                  >
                    <strong>Success!</strong> {{ success }}
                    <button
                      type="button"
                      class="close"
                      data-dismiss="alert"
                      aria-label="Close"
                      @click="removeSuccess"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
                <div class="col-md-12 mb-3" v-if="errors.length">
                  <div
                    class="alert alert-warning alert-dismissible fade show"
                    role="alert"
                    v-for="(error, i) in errors"
                    :key="i"
                  >
                    <strong>Warning!</strong> {{ error }}
                    <button
                      type="button"
                      class="close"
                      data-dismiss="alert"
                      aria-label="Close"
                      @click="removeError(i)"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mb-3 text-right">
                  <button
                    v-if="this.type === 'old'"
                    @click="previewCreative()"
                    type="button"
                    class="btn btn-outline-success btn-lg mr-2"
                  >
                    Preview Creatives
                  </button>
                  <button
                    :disabled="disableBtn"
                    class="btn btn-primary btn-lg"
                    type="button"
                    @click="createCampaign"
                  >
                    {{ btnText }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <preview-modal :data="campaign"></preview-modal>
  </div>
</template>

<script>
export default {
  props: ["type", "data"],
  data() {
    return {
      name: "",
      to: "",
      from: "",
      total_budget: "",
      daily_budget: "",
      creatives: [],
      loading: false,
      errors: [],
      success: "",
      campaign: {},
    };
  },
  computed: {
    title() {
      return "New Campaign";
    },
    btnText() {
      if (this.loading && this.type === "new") {
        return "Creating...";
      }

      if (this.loading && this.type === "old") {
        return "Updating...";
      }

      if (this.type === "old") {
        return "Update";
      }

      return "Create";
    },
    disableBtn() {
      return (
        this.name === "" ||
        this.to === "" ||
        this.from === "" ||
        this.total_budget === "" ||
        this.daily_budget === "" ||
        (!this.creatives.length && this.type === "new")
      );
    },
  },
  methods: {
    onChange(input) {
      if (input.target.files && input.target.files[0]) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.creatives.push({
            url: e.target.result,
            data: input.target.files[0],
          });
          this.$refs.imageInput.value = null;
        };
        reader.readAsDataURL(input.target.files[0]);
      }
    },
    createCampaign() {
      this.loading = true;
      this.errors = [];
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("from", this.from);
      formData.append("to", this.to);
      formData.append("total_budget", this.total_budget);
      formData.append("daily_budget", this.daily_budget);

      for (let i = 0; i < this.creatives.length; i++) {
        formData.append(
          "creatives[" + i + "]",
          this.creatives[i].data,
          this.creatives[i].data.name
        );
      }

      let action = "createCampaign";
      let payload = {
        data: formData,
      };

      if (this.type === "old") {
        action = "updateCampaign";
        payload = {
          data: formData,
          id: this.data.id,
        };
      }

      this.$store
        .dispatch(action, payload)
        .then((res) => {
          this.success = res.data.message;
          this.type === "new" ? this.emptyForm() : this.setForm(res.data.data);
        })
        .catch((err) => {
          if (err.response !== undefined) {
            if (err.response.data !== undefined) {
              if (err.response.data.errors !== undefined) {
                let errors = err.response.data.errors;
                this.errors = [];
                Object.keys(errors).forEach((key) => {
                  errors[key].forEach((err) => {
                    this.errors.push(err);
                  });
                });
              }
            }
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    removeBanner(key) {
      this.creatives.splice(key, 1);
    },
    removeError(key) {
      this.errors.splice(key, 1);
    },
    removeSuccess() {
      this.success = "";
    },
    emptyForm() {
      this.name =
        this.total_budget =
        this.daily_budget =
        this.from =
        this.to =
          "";
      this.creatives = [];
    },
    setForm(data) {
      this.name = data.name;
      this.to = data.to;
      this.from = data.from;
      this.daily_budget = data.daily_budget;
      this.total_budget = data.total_budget;
      this.campaign = data;
      this.creatives = []
    },
    previewCreative() {
      $("#previewModal").modal("show");
    },
  },
  mounted() {
    if (this.type === "old") {
      this.setForm(this.data);
    }
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
