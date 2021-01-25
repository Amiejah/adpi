<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                <h2 class="font-bold mb-4">{{ notEmptyObject(joke) ? 'Edit ' : 'Add ' }} Joke</h2>

                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <form @submit.prevent="setCb(joke)">

                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="setup" class="block text-sm font-medium text-gray-700">The Setup</label>
                                        <input v-model="joke.setup" type="text" name="setup" id="setup" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6">
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">The Punchline</label>
                                        <input v-model="joke.punchline" type="text" name="punchline" id="punchline"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <input type="hidden" v-model="joke.id" name="id">
                                <input type="hidden" v-model="joke.type" name="type">
                                <router-link :to="'/'" class="inline-flex justify-center py-2 px-4 text-sm font-medium">
                                    Cancel
                                </router-link>

                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</template>


<script>
    import { mapActions } from 'vuex'
    export default {
        name: 'edit',
        data() {
            return {
                joke: {}
            }
        },
        methods: {
            notEmptyObject(obj) {
                return Object.keys(obj).length;
            },
            getJokeById: function(id) {
                this.axios.get(`/api/jokes/${id}`)
                    .then((response) => {
                        this.joke = response.data
                    }).catch((error) => {
                        console.log(error);
                    })
            },
            setCb (joke) {
                if (joke['id']) {
                    this.updateJoke(joke);
                } else {
                    this.saveJoke(joke);
                }

                this.$router.push({ path: '/' })
            },
            ...mapActions(['updateJoke', 'saveJoke'])
        },
        created() {
            this.getJokeById(this.$route.params.id);
        }
    }
</script>
