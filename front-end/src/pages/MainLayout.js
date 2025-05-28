import React, { useState }  from 'react';
import Sidebar from '../components/Sidebar';
import { useNavigate } from 'react-router-dom';

function MainLayout({ children }) {
  const navigate = useNavigate();
  const [showSidebar, setShowSidebar] = useState(true);

  const handleLogout = () => {
    navigate('/logout');
  };

  const toggleSidebar = () => {
    setShowSidebar(!showSidebar);
  };

  return (
    <div className="container-fluid">
      <div className="row min-vh-100">
        {/* Sidebar */}
        <div
          className={`${showSidebar ? 'd-block col-md-2' : 'd-none'} bg-dark text-white p-3`}
          style={{ transition: 'all 0.3s ease' }}
        >
          <Sidebar />
        </div>

        {/* Main Content */}
        <div className={showSidebar ? 'col-md-10 p-4' : 'col-12 p-4'}>
          <div className="d-flex justify-content-between mb-3">
            {/* Toggle button */}
            <button className="btn btn-secondary" onClick={toggleSidebar}>
              {showSidebar ? 'Ẩn menu' : 'Hiện menu'}
            </button>

            {/* Logout button */}
            <button className="btn btn-danger" onClick={handleLogout}>
              Đăng xuất
            </button>
          </div>

          {/* Nội dung chính */}
          {children}
        </div>
      </div>
    </div>
  );
}

export default MainLayout;
