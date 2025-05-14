import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate } from 'react-router-dom';
import MainLayout from '../MainLayout';

function CriteriaFormManage() {
  const [forms, setForms] = useState([]);
  const [selectedFormId, setSelectedFormId] = useState(null);
  const [criteriaList, setCriteriaList] = useState([]);
  const [error, setError] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    fetchForms();
  }, []);

  const fetchForms = async () => {
    try {
      const res = await axiosInstance.get('/criteria-forms');
      setForms(res.data);
    } catch {
      setError('Không thể tải danh sách form.');
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Bạn có chắc chắn muốn xóa?')) {
      try {
        await axiosInstance.delete(`/criteria-forms/${id}`);
        fetchForms();
      } catch {
        alert('Xóa thất bại');
      }
    }
  };

  const toggleDetail = async (formId) => {
    navigate(`/form-management/detail/${formId}`);
  };

  return (
    <MainLayout>
      <div className="container mt-4">
        <h3>Danh sách Form đánh giá</h3>
        {error && <div className="alert alert-danger">{error}</div>}
        <button
        className="btn btn-primary mb-3"
        onClick={() => navigate('/form/add')}
      >
        Thêm form mới
      </button>
        <table className="table table-bordered">
          <thead>
            <tr>
              <th>Tên Form</th>
              <th>Chu kỳ đánh giá</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            {forms.map((form) => (
              <React.Fragment key={form.criteria_form_id}>
                <tr>
                  <td>{form.criteria_form_name}</td>
                  <td>{form.evaluation_cycle?.cycle_name || 'N/A'}</td>
                  <td>
                    <button className="btn btn-warning btn-sm me-2" onClick={() => navigate(`/criteria-form/update/${form.criteria_form_id}`)}>Sửa</button>
                    <button className="btn btn-danger btn-sm me-2" onClick={() => handleDelete(form.criteria_form_id)}>Xóa</button>
                    <button className="btn btn-info btn-sm" onClick={() => toggleDetail(form.criteria_form_id)}>
                      {selectedFormId === form.criteria_form_id ? 'Ẩn chi tiết' : 'Chi tiết'}
                    </button>
                  </td>
                </tr>
                {selectedFormId === form.criteria_form_id && (
                  <tr>
                    <td colSpan="3">
                      <strong>Danh sách tiêu chí & câu hỏi:</strong>
                      <ul>
                        {criteriaList.map((criteria) => (
                          <li key={criteria.evaluation_criteria_id}>
                            <strong>{criteria.criteria_name}</strong>
                            <ul>
                              {criteria.questions.map((q) => (
                                <li key={q.evaluation_question_id}>{q.question_name}</li>
                              ))}
                            </ul>
                          </li>
                        ))}
                      </ul>
                    </td>
                  </tr>
                )}
              </React.Fragment>
            ))}
          </tbody>
        </table>
      </div>
    </MainLayout>
  );
}

export default CriteriaFormManage;
