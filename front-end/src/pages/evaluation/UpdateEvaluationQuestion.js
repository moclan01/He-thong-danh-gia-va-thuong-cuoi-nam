import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate, useParams } from 'react-router-dom';
import MainLayout from '../MainLayout';
import FormInput from '../../components/FormInput';

function UpdateEvaluationQuestion() {
  const [formData, setFormData] = useState({ question_text: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetchQuestion();
  }, [id]);

  const fetchQuestion = async () => {
    try {
      const response = await axiosInstance.get(`/evaluation-questions/${id}`);
      setFormData({ question_text: response.data.question_text });
    } catch (err) {
      setError('Không thể tải thông tin câu hỏi đánh giá.');
    }
  };

  const handleInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.put(`/evaluation-questions/${id}`, formData);
      setSuccess('Cập nhật câu hỏi đánh giá thành công.');
      setError('');
      setTimeout(() => navigate('/questions'), 5000); // 5s rồi quay lại
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể cập nhật câu hỏi đánh giá.');
    }
  };

  return (
    <MainLayout>
      <h2>Sửa câu hỏi đánh giá</h2>
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
            Cập nhật
          </button>
        </div>
      </form>
    </MainLayout>
  );
}

export default UpdateEvaluationQuestion;
