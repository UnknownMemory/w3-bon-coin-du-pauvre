const request = async (method, url, body = null, headers = {}) => {
    try {
        const res = await fetch(url, {body, headers: headers, method: method});
        const data = await res.json();

        return data;
    } catch(error) {
        return error;
    }
};

export default request;