<template>
  <div class="card w-100">
    <div class="card-body">
      <h5 calss="card-title">
        <h1>{{ itemTitle }}</h1>
      </h5>
      <h5 calss="card-content">
        <p>{{ itemDescription }}</p>
      </h5>
    </div>
  </div>
</template>

<script>
export default {
  props: { itemTitle: String, itemDescription: String, price: Number },
};
</script>
