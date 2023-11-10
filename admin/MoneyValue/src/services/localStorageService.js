export const setTokenLocalStorage = (token) =>{
    localStorage.setItem('token', token);
};

export const getTokenLocalStorage = () => localStorage.getItem('token');

export const removeTokenLocalStorage = () => localStorage.removeItem('token');