import React, { useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';
import { useNavigate } from 'react-router-dom';
import FormInput from '../../components/FormInput';

function AddEvaluationQuestion() {
  const [formData, setFormData] = useState({ question_text: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();

  const handleInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.post('/evaluation-questions', formData);
      setSuccess('Thêm câu hỏi đánh giá thành công.');
      setError('');
      setFormData({ question_text: '' });
      setTimeout(() => navigate('/questions'), 2000); // Chờ 5s rồi quay lại danh sách
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể thêm câu hỏi đánh giá.');
    }
  };

  return (
    <MainLayout>
      <h2>Thêm câu hỏi đánh giá</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <form onSubmit={handleSubmit}>
        <FormInput
          label="Nội dung câu hỏi"
          name="question_text"
          value={formData.question_text}
          onChange={handleInputChange}
          required
          placeholder="Nhập nội dung câu hỏi"
        />
        <div className="d-flex justify-content-end">
          <button className="btn btn-secondary me-2" onClick={() => navigate('/questions')}>
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

export default AddEvaluationQuestion;
