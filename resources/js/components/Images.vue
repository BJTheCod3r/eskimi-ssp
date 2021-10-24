<template>
  <div class="row">
    <div v-for="(image, i) in images" :key="i" class="col-md-6">
        <img :src="image.url" class="img-fluid" />
    </div>
  </div>
</template>
<script>
export default {
    props: ['images']
}
</script>
