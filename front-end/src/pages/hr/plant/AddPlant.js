import React, { useEffect, useState } from 'react';

import { useNavigate } from 'react-router-dom';
import MainLayout from '../../MainLayout';
import axiosInstance from '../../../services/axiosInstance';
import FormInput from '../../../components/FormInput';

function AddPlant() {
  const [formData, setFormData] = useState({ plant_name: '' });
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
      await axiosInstance.post('/plants', formData);
      setSuccess('Thêm nhà máy thành công.');
      setError('');
      setFormData({ plant_name: '' });
      setTimeout(() => navigate('/plants'), 2000);
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể thêm nhà máy.');
    }
  };

  return (
    <MainLayout>
      <h2>Thêm nhà máy mới</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <form onSubmit={handleSubmit}>
        <FormInput
          label="Tên nhà máy"
          name="plant_name"
          value={formData.plant_name}
          onChange={handleInputChange}
          required
          placeholder="Nhập tên nhà máy"
        />
        <div className="d-flex justify-content-end">
          <button
            className="btn btn-secondary me-2"
            type="button"
            onClick={() => navigate('/plants')}
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

export default AddPlant;