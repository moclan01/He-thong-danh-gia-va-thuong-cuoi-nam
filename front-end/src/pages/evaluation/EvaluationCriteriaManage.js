import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';
import { useNavigate } from 'react-router-dom';

function CriteriaManage() {
  const [criteria, setCriteria] = useState([]);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();

  // Lấy danh sách tiêu chí khi component được gắn
  useEffect(() => {
    fetchCriteria();
  }, []);

  const fetchCriteria = async () => {
    try {
      const response = await axiosInstance.get('/evaluation-criterias');
      setCriteria(response.data);
      setError('');
    } catch (err) {
      setError('Không thể tải danh sách tiêu chí đánh giá.');
      console.error(err);
    }
  };

  // Xử lý xóa tiêu chí
  const handleDelete = async (id) => {
    if (window.confirm('Bạn có chắc muốn xóa tiêu chí đánh giá này không?')) {
      try {
        await axiosInstance.delete(`/evaluation-criterias/${id}`);
        setCriteria(criteria.filter((item) => item.evaluation_criteria_id !== id));
        setSuccess('Xóa tiêu chí đánh giá thành công.');
        setError('');
      } catch (err) {
        setError(err.response?.data?.message || 'Không thể xóa tiêu chí đánh giá.');
      }
    }
  };

  return (
    <MainLayout>
      <h2>Danh sách tiêu chí đánh giá</h2>
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

      <button
        className="btn btn-primary mb-3"
        onClick={() => navigate('/criteria/add')}
      >
        Thêm tiêu chí mới
      </button>

      <table className="table table-bordered">
        <thead>
          <tr>
            <th>Tên tiêu chí</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          {criteria.length > 0 ? (
            criteria.map((criterion) => (
              <tr key={criterion.evaluation_criteria_id}>
                <td>{criterion.criteria_name}</td>
                <td>
                  <button
                    className="btn btn-warning btn-sm me-2"
                    onClick={() => navigate(`/criteria/edit/${criterion.evaluation_criteria_id}`)}
                  >
                    Sửa
                  </button>
                  <button
                    className="btn btn-danger btn-sm me-2"
                    onClick={() => handleDelete(criterion.evaluation_criteria_id)}
                  >
                    Xóa
                  </button>
                  <button
                    className="btn btn-info btn-sm me-2"
                    onClick={() => navigate(`/criterias/${criterion.evaluation_criteria_id}/questions`)}
                  >
                    Xem câu hỏi
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="2" className="text-center">
                Không có tiêu chí nào.
              </td>
            </tr>
          )}
        </tbody>
      </table>
    </MainLayout>
  );
}

export default CriteriaManage;