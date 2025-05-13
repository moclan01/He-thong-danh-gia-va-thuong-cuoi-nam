import React, { useEffect, useState } from 'react';
import axiosInstance from '../services/axiosInstance';
import { useNavigate } from 'react-router-dom';
import MainLayout from './MainLayout';


function Home() {
  const [employee, setEmployee] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    axiosInstance.get('/employee/profile')
      .then(res => setEmployee(res.data))
      .catch(() => navigate('/login'));
  }, [navigate]);

  return (
    <MainLayout>
      <h5>Xin chào, {employee?.fullname || '...'}</h5>
      <h2>Chào mừng đến hệ thống đánh giá nhân viên!</h2>
    </MainLayout>
  );
}

export default Home;