<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/"
        ><img src="/eskimi.svg" class="img-fluid"
      /></a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Campaigns</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <a href="/new" class="btn btn-outline-success my-2 my-sm-0">
            Add New
          </a>
        </form>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  name: "navbar",
  data() {
    return {};
  },
};
</script>
