<template>
  <div class="card">
    <div class="card-body">
      <h5 calss="card-title">
        <h1>{{ itemTitle }}</h1>
      </h5>
      <h5 calss="card-content">
        <p>{{ itemContent }}</p>
      </h5>
    </div>
  </div>
</template>

<script>
export default {
  props: { itemTitle: String, itemContent: String, price: Number },
};
</script>