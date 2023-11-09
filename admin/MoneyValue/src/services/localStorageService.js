export const setTokenLocalStorage = (token) =>{
    localStorage.setItem('token', token);
};

export const getTokenLocalStorage = () =>{
    localStorage.getItem('token');
};