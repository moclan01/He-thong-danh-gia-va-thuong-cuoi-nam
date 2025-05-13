import React, { useState } from 'react';
import axiosInstance from '../../services/axiosInstance';

import MainLayout from '../MainLayout';
import { useNavigate } from 'react-router-dom';
import FormInput from '../../components/FormInput';

function AddCriteria() {
  const [formData, setFormData] = useState({ criteria_name: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  
  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.post('/evaluation-criterias', formData); 
      setSuccess('Thêm tiêu chí đánh giá thành công.');
      setError('');
      setFormData({ criteria_name: '' });
      setTimeout(() => navigate('/criteria-management'), 2000); 
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể thêm tiêu chí đánh giá.');
    }
  };

  return (
    <MainLayout>
      <h2>Thêm tiêu chí đánh giá mới</h2>
      {error && (
        <div className="alert alert-danger" role="alert">
          {error}
        </div>
      )}
      {success && (
        <div className="alert alert-success" role="alert">
          {success}
        </div>
      )}

      <form onSubmit={handleSubmit}>
        <FormInput
          label="Tên tiêu chí"
          name="criteria_name"
          value={formData.criteria_name}
          onChange={handleInputChange}
          required
          placeholder="Nhập tên tiêu chí"
        />
        <div className="d-flex justify-content-end">
          <button
            className="btn btn-secondary me-2"
            type="button"
            onClick={() => navigate('/criteria')}
          >
            Hủy
          </button>
          <button className="btn btn-primary" type="submit">
            Thêm
          </button>
        </div>
      </form>
    </MainLayout>
  );
}

export default AddCriteria;