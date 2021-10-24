<template>
  <div
    class="modal fade"
    id="previewModal"
    tabindex="-1"
    aria-labelledby="previewModalLabel"
    aria-hidden="true"
    ref="previewModal"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="previewModalLabel">{{ data.name }} Creatives</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <images :images="data.creatives"></images>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    props: {
        data: {
            type: Object,
            default: {
                creatives: []
            }
        }
    }
}
</script>
