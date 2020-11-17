<template >
<div>
<fatal-error v-if="error"></fatal-error>
  <div class="row" v-else>
    <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]">
      <div class="card">
        <div class="card-body">
          <div v-if="loading"> Loading...</div>
          <div v-if="hasBooking">
            <p>
             Stayed at <router-link :to="{ name: 'bookable', params: {id: booking.bookable.bookable_id}}">{{ booking.bookable.title }}</router-link>
          </p>
          <p>From {{ booking.from}} to {{ booking.to }}</p>
        </div>
        </div>
      </div>
    </div>
    <div :class="[{'col-md-8': twoColumns}, {'col-md-12': oneColumn}]">
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
                <textarea name="content" rows="10" cols="30" class="form-control" v-model="review.content" :class="[{'is-invalid': errorFor('content')}]"></textarea>
                <div class="invalid-feedback" v-for="(error, index) in errorFor('content')" :key="'content' + index">
                  {{ error }}
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" @click.prevent="submit" :disabled="sending">Submit</button>
        </div>
      </div>
    </div>
  </div>



</div>
</template>

<script>
import {is404, is422} from "./../shared/utils/response";

export default {
    data() {
        return {
            review: {
                id: null,
                rating: 5,
                content: null
            },
            existingReview: null,
            loading: false,
            booking: null,
            error: false,
            errors: null,
            sending: false
        };
    },
    created() {
      this.review.id = this.$route.params.id;
      this.laoding = true;
        //1.If the review already exist
        axios
            .get(`/api/reviews/${this.review.id}`)
            .then(response => {this.existingReview = response.data.data
            })
            .catch(err => {
                if (is404(err)) {
                  return axios
                  .get(`/api/booking-by-review/${this.review.id}`)
                  .then(response => {
                    this.booking = response.data.data;
                  }).catch(err => {
                    this.error = !is404(err);
                  });
                }

                this.error = true;
            })
            .then(() => {
              this.loading = false;
            });
    },
    computed: {
        alreadyReviewed() {
            return this.hasReview || !this.booking;
        },
        hasReview() {
          return this.existingReview !== null;
        },
        hasBooking() {
          return this.booking !== null;
        },
        oneColumn() {
          return !this.loading && this.alreadyReviewed;
        },
        twoColumns() {
          return this.loading || !this.alreadyReviewed;
        }
    },
    methods: {
      submit() {
        //3. store the review
      this.errors = null;
      this.sending = true;
      axios
      .post(`/api/reviews`, this.review)
      .then(response => console.log(response))
      .catch(err => {
        if (is422(err)) {
          const errors = err.response.data.errors;

          if (errors["content"] && 1 ===  _.size(errors)) {
            this.errors = errors;
            return;
          }
        }

        this.error = true;
      })
      .then(() => (this.sending = false));
    },
    errorFor(field) {
      return null !== this.errors && this.errors[field]
       ? this.errors[field]
       : null;
    }
  }
};
</script>
