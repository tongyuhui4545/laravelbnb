<template >
<div>
  <div v-if="loading">
    <h3>Loading.....</h3>
  </div>
  <div v-else>
    <div v-if="alreadyReviewed">
        <h3>You have already left a review!</h3>
    </div>
    <div v-else>
        <div class="form-group">
            <label class="text-muted">Select the star rating (1 is the worst/5 is the best)</label>
            <star-rating class="fa-3x" v-model="review.rating">
            </star-rating>
        </div>
        <div class="formgroup">
            <label for="content" class="text-muted">Describe your experience with</label>
            <textarea name="content" rows="10" cols="30" class="form-control"></textarea>
        </div>
        <button class="btn btn-lg btn-primary btn-block">Submit</button>
    </div>
  </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            review: {
                rating: 5,
                content: null
            },
            existingReview: null,
            loading: false
        };
    },
    created() {
      this.loading = true;
        //1.If the review already exist
        axios
            .get(`/api/reviews/${this.$route.params.id}`)
            .then(response => (this.existingReview = response.data.data))
            .catch(err => {
                //
            })
            .then(() => (this.loading = false));

    },
    computed: {
        alreadyReviewed() {
            return this.existingReview !== null;
        }
    }
};
</script>
