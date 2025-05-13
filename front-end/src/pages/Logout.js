import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axiosInstance from '../services/axiosInstance';

function Logout() {
  const navigate = useNavigate();

  useEffect(() => {
    axiosInstance.post('/logout')
      .then(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
      })
      .catch(error => {
        console.error('Logout failed:', error);
      })
      .finally(() => {
        navigate('/login');
      });
  }, [navigate]);

  return (
    <div className="d-flex justify-content-center align-items-center vh-100">
      <h4>Đang đăng xuất...</h4>
    </div>
  );
}

export default Logout;