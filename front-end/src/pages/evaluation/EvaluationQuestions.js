import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';

function CriteriaQuestions() {
    const { id } = useParams();
    const [questions, setQuestions] = useState([]);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');
    const navigate = useNavigate();

    useEffect(() => {
        fetchQuestions();
    }, [id]);

    const fetchQuestions = async () => {
        try {
            const response = await axiosInstance.get(`/evaluation-criterias/${id}/questions`);
            setQuestions(response.data);
            setError('');
        } catch (err) {
            setError('Không thể tải danh sách câu hỏi.');
            console.error(err);
        }
    };

    const handleDelete = async (questionId) => {
        if (window.confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
            try {
                await axiosInstance.delete(`/evaluation-questions/${questionId}`);
                setQuestions(questions.filter(q => q.evaluation_question_id !== questionId));
                setSuccess('Xóa câu hỏi thành công.');
                setError('');
            } catch (err) {
                setError(err.response?.data?.message || 'Không thể xóa câu hỏi.');
            }
        }
    };

    return (
        <MainLayout>
      <h2>Danh sách câu hỏi của tiêu chí</h2>

      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <div className="mb-3">
        <button className="btn btn-secondary me-2" onClick={() => navigate('/criteria-management')}>
          Quay lại
        </button>
        <button className="btn btn-primary" onClick={() => navigate(`/questions/add/${id}`)}>
          Thêm câu hỏi
        </button>
      </div>

      {questions.length > 0 ? (
        <table className="table table-bordered">
          <thead>
            <tr>
              <th>Nội dung câu hỏi</th>
              <th>Điểm tối đa</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            {questions.map((q) => (
              <tr key={q.evaluation_question_id}>
                <td>{q.question_name}</td>
                <td>{q.max_score}</td>
                <td>
                  <button
                    className="btn btn-warning btn-sm me-2"
                    onClick={() => navigate(`/questions/update/${q.evaluation_question_id}`)}
                  >
                    Sửa
                  </button>
                  <button
                    className="btn btn-danger btn-sm"
                    onClick={() => handleDelete(q.evaluation_question_id)}
                  >
                    Xóa
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      ) : (
        <p>Không có câu hỏi nào.</p>
      )}
    </MainLayout>
    );
}

export default CriteriaQuestions;
