import axios from 'axios';

const api = axios.create({
    baseUrl: '/api/jokes'
});

function getJokesApi(cb) {
    api.get('/api/jokes')
        .then((response) => {
            cb(response.data)
        })
        .catch((error) => {
            console.log(error);
        });
}

function saveJoke( data, cb ) {
    api.post('/api/jokes', data)
        .then((response) => {
            cb(response);
        })
        .catch((error) => {
            console.log(error);
        })
}

function updateJoke (id, data, cb) {
    api.put('/api/jokes/' + id, data)
    .then((response) => {
        cb({status: 201});
    })
    .catch((error) => {
        console.log(error);
    });
}


export default {
    getJokes: (cb) => getJokesApi(cb),
    saveJoke: (data, cb) => saveJoke(data, cb),
    updateJoke: (id, data, cb) => updateJoke(id, data, cb)
}
