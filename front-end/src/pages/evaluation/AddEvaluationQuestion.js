import React, { useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';

function AddQuestion() {
  const { criteriaId } = useParams(); // Lấy ID tiêu chí từ URL
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    question_name: '',
    max_score: ''
  });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.post('/evaluation-questions', {
        ...formData,
        evaluation_criteria_id: criteriaId
      });
      setSuccess('Thêm câu hỏi thành công.');
      setError('');
      setTimeout(() => navigate(`/criterias/${criteriaId}/questions`), 1500);
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể thêm câu hỏi.');
    }
  };

  return (
    <MainLayout>
      <h2>Thêm câu hỏi cho tiêu chí</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label>Câu hỏi</label>
          <input
            type="text"
            name="question_name"
            className="form-control"
            value={formData.question_name}
            onChange={handleChange}
            required
            placeholder="Nhập nội dung câu hỏi"
          />
        </div>
        <div className="mb-3">
          <label>Điểm tối đa</label>
          <input
            type="number"
            name="max_score"
            className="form-control"
            value={formData.max_score}
            onChange={handleChange}
            required
            placeholder="Nhập điểm tối đa"
          />
        </div>
        <div className="d-flex justify-content-end">
          <button className="btn btn-secondary me-2" onClick={() => navigate(-1)}>Hủy</button>
          <button type="submit" className="btn btn-primary">Thêm</button>
        </div>
      </form>
    </MainLayout>
  );
}

export default AddQuestion;
