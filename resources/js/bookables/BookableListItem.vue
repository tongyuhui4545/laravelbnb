<template>
<div class="card w-100">
    <div class="card-body">
        <h5 calss="card-title">
            <router-link :to="{ name: 'bookable', params: {id} }">
                <h1>{{ title }}</h1>
            </router-link>
        </h5>
        <h5 calss="card-content">
            <p>{{ description }}</p>
        </h5>
    </div>
</div>
</template>

<script>
export default {
    props: {
        title: String,
        description: String,
        id: Number
    },
};
</script>
