// src/layouts/MainLayout.js
import React from 'react';
import Sidebar from '../components/Sidebar';
import { useNavigate } from 'react-router-dom';

function MainLayout({ children }) {
  const navigate = useNavigate();

  const handleLogout = () => {
    navigate('/logout');
  };

  return (
    <div className="container-fluid">
      <div className="row min-vh-100">
        <div className="col-md-3 bg-dark text-white p-3">
          <Sidebar />
        </div>

        <div className="col-md-9 p-4">
          <div className="d-flex justify-content-end mb-3">
            <button className="btn btn-danger" onClick={handleLogout}>
              Đăng xuất
            </button>
          </div>

          {/* Nội dung trang cụ thể */}
          {children}
        </div>
      </div>
    </div>
  );
}

export default MainLayout;
