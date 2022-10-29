const HOST = 'http://127.0.0.1:1234'

const like = document.querySelector('#like');
const dislike = document.querySelector('#dislike');

const request = async (method, url, body = null, headers = {}) => {
    try {
        const res = await fetch(url, {body, headers: headers, method: method});
        const data = await res.json();

        return data;
    } catch(error) {
        return error;
    }
};



const voteEvent = (element, voteBool) => {
    element.addEventListener('click', async () => {
        const vendeurId = element.parentNode.getAttribute('data-vendeur-id');
    
        const formdata = new FormData();
        formdata.append('aVoter', voteBool);
        
        res = await request('POST', `${HOST}/votes/process/${vendeurId}`, formdata);
        // if(res?.vote){
        //     element.classList.add('bg-green-600')
        // } else {
        //     element.classList.add('bg-red-600')
        // }
    })
}

voteEvent(like, 1);
voteEvent(dislike, 0)