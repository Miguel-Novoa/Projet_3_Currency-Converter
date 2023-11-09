import axios, {AxiosError } from "axios";
import { setTokenLocalStorage } from "./localStorageService";

const url = "http://127.0.0.1:8000";


export async function login(name, password) {
    axios.post(`${url + '/api/login'}`, {
      "name": name,
      "password": password
    })
    .then((response) => {
      setTokenLocalStorage(response.token)
      console.log(response);
    });
}

export async function getPairs(){
  axios.get(`${url + '/pairs/get'}`)
  .then((response) => {
    console.log(response)
  })
}