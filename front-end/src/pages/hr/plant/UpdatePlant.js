import React, { useEffect, useState } from 'react';

import { useNavigate, useParams } from 'react-router-dom';
import MainLayout from '../../MainLayout';
import axiosInstance from '../../../services/axiosInstance';
import FormInput from '../../../components/FormInput';

function UpdatePlant() {
  const [formData, setFormData] = useState({ plant_name: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();
  const { id } = useParams();

  useEffect(() => {
    fetchPlant();
  }, [id]);

  const fetchPlant = async () => {
    try {
      const response = await axiosInstance.get(`/plants/${id}`);
      setFormData({ plant_name: response.data.plant_name });
      setError('');
    } catch (err) {
      setError('Không thể tải thông tin nhà máy.');
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.put(`/plants/${id}`, formData);
      setSuccess('Cập nhật nhà máy thành công.');
      setError('');
      setTimeout(() => navigate('/plants'), 2000);
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể cập nhật nhà máy.');
    }
  };

  return (
    <MainLayout>
      <h2 className="mb-4">Sửa thông tin nhà máy</h2>
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
        <div className="d-flex justify-content-end mt-3">
          <button
            type="button"
            className="btn btn-secondary me-2"
            onClick={() => navigate('/plants')}
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

export default UpdatePlant;