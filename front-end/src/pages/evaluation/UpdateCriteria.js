import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import FormInput from '../../components/FormInput';

import { useNavigate, useParams } from 'react-router-dom';
import MainLayout from '../MainLayout';

function UpdateCriteria() {
  const [formData, setFormData] = useState({ criteria_name: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();
  const { id } = useParams();

  useEffect(() => {
    fetchCriterion();
  }, [id]);

  const fetchCriterion = async () => {
    try {
      const response = await axiosInstance.get(`/evaluation-criterias/${id}`);
      setFormData({ criteria_name: response.data.criteria_name });
      setError('');
    } catch (err) {
      setError('Không thể tải thông tin tiêu chí đánh giá.');
      console.error(err);
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  }

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.put(`/evaluation-criterias/${id}`, formData);
      setSuccess('Cập nhật tiêu chí đánh giá thành công.');
      setError('');
      setTimeout(() => navigate('/criteria-management'), 2000);
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể cập nhật tiêu chí đánh giá.');
    }
  };

  return (
    <MainLayout>
      <h2 className="mb-4">Sửa tiêu chí đánh giá</h2>

      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <form onSubmit={handleSubmit}>
        <FormInput
          label="Tên tiêu chí"
          name="criteria_name"
          value={formData.criteria_name}
          onChange={handleInputChange}
          required
          placeholder="Nhập tên tiêu chí"
        />

        <div className="d-flex justify-content-end mt-3">
          <button
            type="button"
            className="btn btn-secondary me-2"
            onClick={() => navigate('/criteria')}
          >
            Hủy
          </button>
          <button type="submit" className="btn btn-primary">
            Cập nhật
          </button>
        </div>
      </form>
    </MainLayout>
  );
}

export default UpdateCriteria;