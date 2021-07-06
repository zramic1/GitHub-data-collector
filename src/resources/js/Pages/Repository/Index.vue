<template>
  <div>
    <h1 class="font-bold text-3xl pb-6">Repositories</h1>
    <div class="flex flex-row gap-4 pb-6">
      <text-input v-model="nickname" :error="errors.nickname" class="w-1/2" :placeholder="'Type your GitHub nickname...'"/>
      <button class="btn-indigo" title="Confirm" @click.prevent="showRepositories">
        <icon name="check" class="fill-white h-4 w-4"/>
      </button>
    </div>
    <div v-if="repositoriesForJsonFile.length">
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
        <repository-card v-for="(repository, index) in repositoriesForJsonFile"
                         :key="repositoriesForJsonFile[index].id"
                         v-model="repositoriesForJsonFile[index]"
                         :repository="repository"
                         @deleteRepository="deleteRepository(index)"
        />
      </div>
    </div>
    <warning v-else
             :text="'Sorry! You do not have any repositories.'"
    />
  </div>
</template>

<script>
import Layout from '../../Layouts/Layout'
import RepositoryCard from '../../Components/Common/Repository/RepositoryCard'
import Icon from '../../Components/Shared/Icon'
import TextInput from '../../Components/Shared/TextInput'
import Warning from '../../Components/Shared/Warning'

export default {
  name: 'Index',
  components: {TextInput, RepositoryCard, Icon, Warning },
  layout: Layout,
  props: {
    repositories: Array,
    fileExists: Boolean,
    userNickname: String,
    errors: Object
  },
  data() {
    return {
      repositoriesForJsonFile: this.repositories,
      nickname: this.userNickname,
    }
  },
  methods: {
    deleteRepository(index) {
      this.repositoriesForJsonFile.splice(index, 1)
    },
    saveChanges() {
      this.$inertia.post(this.route('web.repositories.store'), {
        repositories: this.repositoriesForJsonFile,
        nickname: this.nickname
      })
    },
    showRepositories() {
      this.$inertia.get(this.route('web.repositories.index'), {
        nickname: this.nickname,
      })
    },
    generateFileDownloadUrl() {
      return `/repositories/download/${this.nickname}`
    },
  },
}
</script>

<style scoped>

</style>
