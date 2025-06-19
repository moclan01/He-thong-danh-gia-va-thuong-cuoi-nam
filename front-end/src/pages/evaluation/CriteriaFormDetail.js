import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate, useParams } from 'react-router-dom';
import MainLayout from '../MainLayout';

function CriteriaFormDetail() {
  const { formId } = useParams(); 
  const [formDetail, setFormDetail] = useState(null);
  const [error, setError] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    fetchFormDetail();
  }, [formId]);

  const fetchFormDetail = async () => {
    try {
      const formRes = await axiosInstance.get(`/criteria-forms/${formId}/criterias`);
      const formData = formRes.data;

      // Gọi API để lấy câu hỏi cho mỗi tiêu chí
      const criteriaWithQuestions = await Promise.all(
        formData.map(async (criteria) => {
          const questionsRes = await axiosInstance.get(`/evaluation-criterias/${criteria.evaluation_criteria_id}/questions`);
          return {
            ...criteria,
            questions: questionsRes.data,
          };
        })
      );
      setFormDetail(criteriaWithQuestions);
    } catch {
      setError('Không thể tải chi tiết form đánh giá.');
    }
  };

  return (
     <MainLayout>
      <div className="container mt-4">
        <h3>Chi tiết Form Đánh Giá</h3>
        {error && <div className="alert alert-danger">{error}</div>}

        {formDetail ? (
          <div>
            <h4>Danh sách tiêu chí đánh giá</h4>
            <table className="table table-bordered criteria-form-detail">
              <thead>
                <tr>
                  <th>Tên tiêu chí</th>
                  <th>Câu hỏi</th>
                  <th>Điểm tối đa</th>
                </tr>
              </thead>
              <tbody>
                {formDetail.map((criteria) => (
                  <tr key={criteria.evaluation_criteria_id}>
                    <td>{criteria.criteria_name}</td>
                    <td>
                      <ul className="list-unstyled">
                        {criteria.questions.map((question) => (
                          <li key={question.evaluation_question_id}>
                            {question.question_name}
                          </li>
                        ))}
                      </ul>
                    </td>
                    <td>
                      <ul className="list-unstyled">
                        {criteria.questions.map((question) => (
                          <li key={question.evaluation_question_id}>
                            {question.max_score}
                          </li>
                        ))}
                      </ul>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ) : (
          <div>Đang tải dữ liệu...</div>
        )}

        <button className="btn btn-primary mt-3" onClick={() => navigate('/form-management')}>
          Quay lại
        </button>
      </div>
    </MainLayout>
  );
}

export default CriteriaFormDetail;
