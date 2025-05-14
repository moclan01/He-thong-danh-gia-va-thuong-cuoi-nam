import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate, useParams } from 'react-router-dom';
import MainLayout from '../MainLayout';
import FormInput from '../../components/FormInput';

function UpdateCycle() {
  const [formData, setFormData] = useState({
    cycle_name: '',
    start_date: '',
    end_date: '',
    status: '',
    department_id: '',
  });
  const [departments, setDepartments] = useState([]);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();
  const { id } = useParams();

  useEffect(() => {
    fetchCycle();
    fetchDepartments();
  }, [id]);

  const fetchCycle = async () => {
    try {
      const res = await axiosInstance.get(`/evaluation-cycles/${id}`);
      setFormData(res.data);
    } catch (err) {
      setError('Không thể tải chu kỳ.');
    }
  };

  const fetchDepartments = async () => {
    try {
      const res = await axiosInstance.get('/departments');
      setDepartments(res.data);
    } catch (err) {
      console.error('Không thể tải danh sách phòng ban');
    }
  };

  const handleChange = e => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async e => {
    e.preventDefault();
    try {
      await axiosInstance.put(`/evaluation-cycles/${id}`, formData);
      setSuccess('Cập nhật thành công.');
      setTimeout(() => navigate('/cycle-management'), 2000);
    } catch (err) {
      setError('Không thể cập nhật chu kỳ.');
    }
  };

  return (
    <MainLayout>
      <h2>Cập nhật chu kỳ</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}
      <form onSubmit={handleSubmit}>
        <FormInput
          label="Tên chu kỳ"
          name="cycle_name"
          value={formData.cycle_name}
          onChange={handleChange}
          required
        />
        <div className="mb-3">
          <label htmlFor="department_id" className="form-label">Phòng ban</label>
          <select
            className="form-select"
            name="department_id"
            value={formData.department_id}
            onChange={handleChange}
            required
          >
            <option value="">-- Chọn phòng ban --</option>
            {departments.map(dept => (
              <option key={dept.department_id} value={dept.department_id}>
                {dept.department_name}
              </option>
            ))}
          </select>
        </div>
        <FormInput
          label="Ngày bắt đầu"
          name="start_date"
          type="date"
          value={formData.start_date}
          onChange={handleChange}
          required
        />
        <FormInput
          label="Ngày kết thúc"
          name="end_date"
          type="date"
          value={formData.end_date}
          onChange={handleChange}
          required
        />
        <div className="mb-3">
          <label htmlFor="status" className="form-label">Trạng thái</label>
          <select
            className="form-select"
            name="status"
            value={formData.status}
            onChange={handleChange}
            required
          >
            <option value="">-- Chọn trạng thái --</option>
            <option value="open">Mở</option>
            <option value="pending">Chờ xử lý</option>
            <option value="closed">Đã đóng</option>
          </select>
        </div>
        <div className="d-flex justify-content-end">
          <button className="btn btn-secondary me-2" type="button" onClick={() => navigate('/cycle-management')}>Hủy</button>
          <button className="btn btn-primary" type="submit">Cập nhật</button>
        </div>
      </form>
    </MainLayout>
  );
}

export default UpdateCycle;
