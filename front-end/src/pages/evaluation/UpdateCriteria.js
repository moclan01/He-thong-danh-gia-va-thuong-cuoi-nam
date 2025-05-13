import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import FormInput from '../../components/FormInput';

import { Button, Alert } from 'react-bootstrap';
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
      setTimeout(() => navigate('/criteria'), 2000); // Chuyển hướng sau 2 giây
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể cập nhật tiêu chí đánh giá.');
    }
  };

  return (
    <MainLayout>
      <h2>Sửa tiêu chí đánh giá</h2>
      {error && <Alert variant="danger">{error}</Alert>}
      {success && <Alert variant="success">{success}</Alert>}

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
          <Button
            variant="secondary"
            onClick={() => navigate('/criteria')}
            className="me-2"
          >
            Hủy
          </Button>
          <Button type="submit" variant="primary">
            Cập nhật
          </Button>
        </div>
      </form>
    </MainLayout>
  );
}

export default UpdateCriteria;