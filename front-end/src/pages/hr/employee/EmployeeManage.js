import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import MainLayout from '../../MainLayout';
import axiosInstance from '../../../services/axiosInstance';

function EmployeeManage() {
  const [employees, setEmployees] = useState([]);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    fetchEmployees();
  }, []);

  const fetchEmployees = async () => {
    try {
      const response = await axiosInstance.get('/employees');
      setEmployees(response.data);
      console.log(response.data);
      setError('');
    } catch (err) {
      setError('Không thể tải danh sách nhân viên.');
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Bạn có chắc muốn xóa nhân viên này không?')) {
      try {
        await axiosInstance.delete(`/employees/${id}`);
        setEmployees(employees.filter(emp => emp.employee_id !== id));
        setSuccess('Xóa nhân viên thành công.');
        setError('');
      } catch (err) {
        setError(err.response?.data?.message || 'Không thể xóa nhân viên.');
      }
    }
  };

  const handleDetail = async (id) => {

  }

  return (
    <MainLayout>
      <h2>Danh sách nhân viên</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <button className="btn btn-primary mb-3" onClick={() => navigate('/employee/add')}>
        Thêm nhân viên
      </button>

      <table className="table table-bordered">
        <thead>
          <tr>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Phòng ban</th>
            <th>Plant</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          {employees.length > 0 ? (
            employees.map(emp => (
              <tr key={emp.employee_id}>
                <td>{emp.code}</td>
                <td>{emp.fullname}</td>
                <td>{emp.department? emp.department.department_name : 'Chưa có'}</td>
                <td>{emp.plant? emp.plant.plant_name : 'Chưa có'}</td>
                <td>
                  <button className="btn btn-warning btn-sm me-2" onClick={() => navigate(`/employee/update/${emp.employee_id}`)}>
                    Sửa
                  </button>
                  <button className="btn btn-danger btn-sm me-2" onClick={() => handleDelete(emp.employee_id)}>
                    Xóa
                  </button>
                  <button className="btn btn-info btn-sm" onClick={() => handleDetail(`/employee/detail/${emp.employee_id}`)}>
                    Chi tiết
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4" className="text-center">Không có nhân viên nào.</td>
            </tr>
          )}
        </tbody>
      </table>
    </MainLayout>
  );
}

export default EmployeeManage;
