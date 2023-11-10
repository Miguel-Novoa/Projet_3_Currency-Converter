import axios, {AxiosError } from "axios";
import { setTokenLocalStorage, removeTokenLocalStorage } from "./localStorageService";

const url = "http://127.0.0.1:8000/api";


export async function login(name, password) {
  try {
    const response = await axios.post(`${url}/login`, {
      name: name,
      password: password
    });

    setTokenLocalStorage(response.data.token);

    return response;
  } catch (error) {
    throw error;
  }
}

export async function getPairs(){
  axios.get(`${url + '/pairs/get'}`)
  .then((response) => {
    console.log(response)
  })
}