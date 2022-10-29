const HOST = 'http://127.0.0.1:1234'

const request = async (method, url, body = null, headers = {}) => {
    try {
        const res = await fetch(url, {body, headers: headers, method: method});
        const data = await res.json();

        return data;
    } catch(error) {
        return error;
    }
};

const formdata = new FormData();
formdata.append('aVoter', true);

request('POST', `${HOST}/votes/process/1`, formdata);