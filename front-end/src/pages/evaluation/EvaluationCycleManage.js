import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate } from 'react-router-dom';
import MainLayout from '../MainLayout';

function CycleManage() {
  const [cycles, setCycles] = useState([]);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [departments, setDepartments] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    fetchCycles();
    fetchDepartments();
  }, []);

  const fetchCycles = async () => {
    try {
      const res = await axiosInstance.get('/evaluation-cycles');
      setCycles(res.data);
    } catch (err) {
      setError('Không thể tải danh sách chu kỳ.');
    }
  };

  const fetchDepartments = async () => {
    try {
      const res = await axiosInstance.get('/departments');
      setDepartments(res.data);
    } catch (err) {
      console.error('Không thể tải phòng ban');
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Bạn có chắc muốn xóa chu kỳ này không?')) {
      try {
        await axiosInstance.delete(`/evaluation-cycles/${id}`);
        setCycles(cycles.filter(cycle => cycle.evaluation_cycle_id !== id));
        setSuccess('Xóa chu kỳ thành công.');
        setError('');
      } catch (err) {
        setError('Không thể xóa chu kỳ.');
      }
    }
  };

  const getDepartmentName = (id) => {
    const dept = departments.find(d => d.department_id === id);
    return dept ? dept.department_name : 'Không xác định';
  }

  return (
    <MainLayout>
      <h2>Danh sách chu kỳ đánh giá</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <button className="btn btn-primary mb-3" onClick={() => navigate('/cycle/add')}>
        Thêm chu kỳ
      </button>

      <table className="table table-bordered">
        <thead>
          <tr>
            <th>Tên chu kỳ</th>
            <th>Phòng ban</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          {cycles.length > 0 ? cycles.map((cycle) => (
            <tr key={cycle.evaluation_cycle_id}>
              <td>{cycle.cycle_name}</td>
              <td>{getDepartmentName(cycle.department_id)}</td>
              <td>{cycle.start_date}</td>
              <td>{cycle.end_date}</td>
              <td>
                <button
                  className="btn btn-warning btn-sm me-2"
                  onClick={() => navigate(`/cycle/update/${cycle.evaluation_cycle_id}`)}
                >
                  Sửa
                </button>
                <button
                  className="btn btn-danger btn-sm"
                  onClick={() => handleDelete(cycle.evaluation_cycle_id)}
                >
                  Xóa
                </button>
              </td>
            </tr>
          )) : (
            <tr><td colSpan="5" className="text-center">Không có chu kỳ nào.</td></tr>
          )}
        </tbody>
      </table>
    </MainLayout>
  );
}

export default CycleManage;
