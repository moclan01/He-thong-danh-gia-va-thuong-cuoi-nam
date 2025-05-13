import React, { useEffect, useState } from 'react';
import axiosInstance from '../services/axiosInstance';
import Sidebar from '../components/Sidebar';
import { useNavigate } from 'react-router-dom';
import MainLayout from './MainLayout';

function Profile() {
  const [employee, setEmployee] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    axiosInstance.get('/employee/profile')
      .then(res => setEmployee(res.data))
      .catch(() => navigate('/login'));
  }, [navigate]);


  return (
    <MainLayout>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <strong>Xin chào, {employee?.fullname || '...'}</strong>
      </div>

      <h2>Thông tin nhân viên</h2>
      {employee ? (
        <table className="table table-bordered mt-3">
          <tbody>
            <tr><th>Mã nhân viên</th><td>{employee.code}</td></tr>
            <tr><th>Họ tên</th><td>{employee.fullname}</td></tr>
            <tr><th>Phòng ban</th><td>{employee.department?.department_name || 'Chưa có'}</td></tr>
            <tr><th>Vị trí</th><td>{employee.position?.position_name || 'Chưa có'}</td></tr>
            <tr><th>Nhà máy</th><td>{employee.plant?.plant_name || 'Chưa có'}</td></tr>
            <tr><th>Mã quản lý</th><td>{employee.manager?.code || 'Chưa có'}</td></tr>
            <tr><th>Tên quản lý</th><td>{employee.manager?.fullname || 'Chưa có'}</td></tr>
            <tr><th>Bộ phận (division)</th><td>{employee.division}</td></tr>
            <tr><th>Lương cơ bản</th><td>{employee.basic}</td></tr>
            <tr><th>Bậc (grade)</th><td>{employee.grade}</td></tr>
            <tr><th>Loại nhân viên</th><td>{employee.stafftype}</td></tr>
            <tr><th>Ngày bắt đầu</th><td>{employee.start_date}</td></tr>
            <tr><th>Loại</th><td>{employee.type}</td></tr>
          </tbody>
        </table>
      ) : (
        <p>Đang tải thông tin nhân viên...</p>
      )}
    </MainLayout>
  );
}

export default Profile;
