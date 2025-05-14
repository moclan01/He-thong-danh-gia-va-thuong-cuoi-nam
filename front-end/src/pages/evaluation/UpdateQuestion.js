import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';

function UpdateQuestion() {
  const { id } = useParams(); // evaluation_question_id
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    question_name: '',
    max_score: '',
    evaluation_criteria_id: ''
  });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchQuestion();
  }, [id]);

  const fetchQuestion = async () => {
    try {
      const res = await axiosInstance.get(`/evaluation-questions/${id}`);
      setFormData({
        question_name: res.data.question_name,
        max_score: res.data.max_score,
        evaluation_criteria_id: res.data.evaluation_criteria_id
      });
    } catch (err) {
      setError('Không thể tải dữ liệu câu hỏi.');
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axiosInstance.put(`/evaluation-questions/${id}`, formData);
      setSuccess('Cập nhật câu hỏi thành công.');
      setError('');
      setTimeout(() => navigate(`/criterias/${formData.evaluation_criteria_id}/questions`), 1500);
    } catch (err) {
      setError(err.response?.data?.message || 'Không thể cập nhật câu hỏi.');
    }
  };

  return (
    <MainLayout>
      <h2>Sửa câu hỏi đánh giá</h2>
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
          />
        </div>
        <div className="d-flex justify-content-end">
          <button className="btn btn-secondary me-2" onClick={() => navigate(-1)}>Hủy</button>
          <button type="submit" className="btn btn-primary">Cập nhật</button>
        </div>
      </form>
    </MainLayout>
  );
}

export default UpdateQuestion;
