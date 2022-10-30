import request from './request.js'

const HOST = 'http://127.0.0.1:1234';

const like = document.querySelector('#like');
const dislike = document.querySelector('#dislike');
const vendeurId = document.querySelector('div[data-vendeur-id]').getAttribute('data-vendeur-id')

const getVotes = async () => {
    const totalVotes = document.querySelector('#total-votes');
    const positiveVotes = document.querySelector('#positive-votes');

    let res = await request('GET', `${HOST}/votes/all/${vendeurId}`);

    positiveVotes.innerHTML = res.positive_votes;
    totalVotes.innerHTML = res.total_votes;
}

const getUserVote = async () => {
    let res = await request('GET', `${HOST}/votes/get/${vendeurId}`);
    return res;
}

const voteEvent = (element, voteBool) => {
    element.addEventListener('click', async () => {
        const formdata = new FormData();
        formdata.append('aVoter', voteBool);
        
        let res = await request('POST', `${HOST}/votes/process/${vendeurId}`, formdata);
        getVotes();
        setBtnColor(res);
    })
}

const setBtnColor = (vote) => {
    if(vote.vote){
        dislike.classList.remove('bg-red-600')
        like.classList.add('bg-green-600')
    } else {
        like.classList.remove('bg-green-600')
        dislike.classList.add('bg-red-600')
    }
}

if(like !== null){
    voteEvent(like, 1);
    voteEvent(dislike, 0)
    
    getUserVote().then(vote => {
        setBtnColor(vote);
    })
}

getVotes();