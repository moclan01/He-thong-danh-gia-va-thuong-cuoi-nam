import React, { useEffect, useState } from 'react';
import axiosInstance from '../services/axiosInstance';
import { useNavigate } from 'react-router-dom';
import Sidebar from '../components/Sidebar';


function Home() {
  const [employee, setEmployee] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    axiosInstance.get('/employee/profile')
      .then(res => setEmployee(res.data))
      .catch(() => navigate('/login'));
  }, [navigate]);

  const handleLogout = () => {
    axiosInstance.post('/logout').then(() => {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      navigate('/login');
    });
  };

  return (
    <div className="container-fluid">
      <div className="row min-vh-100">
        {/* Sidebar */}
        <div className="col-md-3 bg-dark text-white p-3">
          <Sidebar />
        </div>

        {/* Content */}
        <div className="col-md-9 p-4">
          <div className="d-flex justify-content-between align-items-center mb-4">
            <h5>Xin chào, {employee?.fullname || '...'}</h5>
            <button className="btn btn-danger" onClick={handleLogout}>
              Đăng xuất
            </button>
          </div>
          <h2>Chào mừng đến hệ thống đánh giá nhân viên!</h2>
        </div>
      </div>
    </div>
  );
}

export default Home;