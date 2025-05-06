import api from "./axiosInstance";

export const login = async (credentials) => {
    try {
      const response = await api.post('/login', credentials);
      const { token, user } = response.data;
      localStorage.setItem('authToken', token);
      localStorage.setItem('user', JSON.stringify(user));
      return response.data;
    } catch (error) {
      throw error.response ? error.response.data : new Error('Network error');
    }
  };
  
  export const logout = async () => {
    try {
      await api.post('/logout');
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
    } catch (error) {
      throw error.response ? error.response.data : new Error('Network error');
    }
  };
  
  export const getCurrentUser = () => {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
  };