<template>
  <div>
    <h1 class="font-bold text-3xl pb-6">Followers</h1>
    <div v-if="followersForJsonFile.length">
      <div class="flex flex-row gap-6 pb-6">
        <button class="btn-indigo flex flex-row gap-2" @click.prevent="saveChanges">
          <icon name="check" class="fill-white h-4 w-4" />
          Apply changes
        </button>
        <a v-if="fileExists" :href="generateFileDownloadUrl()" class="btn-indigo flex flex-row gap-2">
          <icon name="file-download" class="fill-white h-4 w-4" />
          Download JSON file
        </a>
      </div>
      <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2 gap-4">
        <follower-card v-for="(follower, index) in followersForJsonFile"
                       :key="followersForJsonFile[index].id"
                       v-model="followersForJsonFile[index]"
                       :follower="follower"
                       @deleteFollower="deleteFollower(index)"
        />
      </div>
    </div>
    <warning v-else
             :text="'Sorry! You do not have any followers.'"
    />
  </div>
</template>

<script>
import Layout from '../../Layouts/Layout'
import Icon from '../../Components/Shared/Icon'
import FollowerCard from '../../Components/Common/Follower/FollowerCard'
import Warning from '../../Components/Shared/Warning'

export default {
  name: 'Index',
  components: { Icon, FollowerCard, Warning },
  layout: Layout,
  props: {
    followers: Array,
    fileExists: Boolean,
  },
  data() {
    return {
      followersForJsonFile: this.followers,
    }
  },
  methods: {
    saveChanges() {
      this.$inertia.post(this.route('web.followers.store'), {
        followers: this.followersForJsonFile,
      })
    },
    deleteFollower(index) {
      this.followersForJsonFile.splice(index, 1)
    },
    generateFileDownloadUrl() {
      return '/followers/download'
    },
  },
}
</script>

<style scoped>

</style>
