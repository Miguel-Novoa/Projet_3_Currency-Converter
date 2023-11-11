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
  try {
    const response = await axios.get(`${url + '/pairs/get'}`);
    return response;
  } catch (error) {
    throw error;
  }
}

export async function addPair(sourceId, targetId, rate){
  try{
    const response = await axios.post(`${url + '/pairs/add'}`, {
      source_currency_id: sourceId,
      target_currency_id: targetId,
      rate: rate
    });

    return response;
  } catch (error) {
    throw error;
  }
}

export async function editPair(id, rate){
  try{
    const response = await axios.put(`${url + '/pairs/update/' + id}`, {
      rate: rate
    });

    return response;
  } catch (error) {
    throw error;
  }
}

export async function deletePair(id){
  try{
    const response = await axios.delete(`${url + '/pairs/delete/' + id}`);
    return response;
  } catch (error) {
    throw error;
  }
}

export async function pairConversions(id){
  try{
    const response = await axios.put(`${url + '/pairs/convert/' + id}`);
    return response;
  } catch (error) {
    throw error;
  }
}

export async function getCurrencies(){
  try {
    const response = await axios.get(`${url + '/currencies/get'}`);
    return response;
  } catch (error) {
    throw error;
  }
}

export async function getCurrency(id){
  try {
    const response = await axios.get(`${url + '/currencies/get/' + id}`);
    return response.data.data;
  } catch (error) {
    throw error;
  }
}

export async function addCurrency(code, infos){
  try{
    const response = await axios.post(`${url + '/currencies/add'}`, {
      code : code,
      infos : infos
    });
    return response;
  } catch (error) {
    throw error;
  }
}