import JokesApi from '../../api/jokes';

const state = {
    all: [],
}


// initial getters
const getters = {
    allJokes: state => {
        return state.all.sort((a, b) => {
            return a['id'] < b['id']
        })
    },
}


const actions = {
    // Fetch all the data
    getAllJokes ({commit}) {
        JokesApi.getJokes(jokes => {
            commit('SHOW_ALL_JOKES', jokes)
        })
    },
    // Save data
    saveJoke ({commit}, data) {
        JokesApi.saveJoke(data, (response) => {
            if (response.status === 201) {
                state.message = 'Stored data successfully'
            }
        })
    },
    // Update joke
    updateJoke( {commit}, joke ) {
        JokesApi.updateJoke(joke.id, joke, (response) => {
            if(response.status === 201) {
                state.message = 'Joke is updated, ha-ha'
            }
        })
    }
}


const mutations = {
    SHOW_ALL_JOKES ( state, jokes) {
        state.all = jokes;
    }
}


export default {
    state,
    getters,
    actions,
    mutations,
}
