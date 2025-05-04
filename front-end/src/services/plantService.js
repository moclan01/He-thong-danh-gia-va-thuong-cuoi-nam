import api from './axiosInstance';

export const getPlants = async () => {
  const response = await api.get('/plants');
  return response.data;
};

export const getPlantById = async (id) => {
  const response = await api.get(`/plants/${id}`);
  return response.data;
};

export const createPlant = async (data) => {
  const response = await api.post('/plants', data);
  return response.data;
};

export const updatePlant = async (id, data) => {
  const response = await api.put(`/plants/${id}`, data);
  return response.data;
};

export const deletePlant = async (id) => {
  const response = await api.delete(`/plants/${id}`);
  return response.data;
};