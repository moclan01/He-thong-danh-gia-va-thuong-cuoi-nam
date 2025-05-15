import React, { useEffect, useState } from 'react';
import MainLayout from './MainLayout';
import axiosInstance from '../services/axiosInstance';

function EmployeeSelfEvaluation() {
  const [profile, setProfile] = useState({});
  const [evaluationCycles, setEvaluationCycles] = useState([]);
  const [selectedCycle, setSelectedCycle] = useState('');
  const [criteriaForm, setCriteriaForm] = useState(null);
  const [criterias, setCriterias] = useState([]);
  const [questions, setQuestions] = useState([]);
  const [scores, setScores] = useState({}); // lưu điểm theo question_id

  useEffect(() => {
    fetchProfileAndCycles();
  }, []);

  const fetchProfileAndCycles = async () => {
    try {
      const res = await axiosInstance.get('/employee/profile');
      setProfile(res.data);

      const code = res.data.code;
      const cycleRes = await axiosInstance.get(`/employees/${code}/evaluation-cycles`);
      setEvaluationCycles(cycleRes.data);
    } catch (error) {
      console.error('Lỗi khi lấy hồ sơ hoặc chu kỳ:', error);
    }
  };

  const fetchFormAndQuestions = async (cycleId) => {
    try {
      const formRes = await axiosInstance.get(`/evaluation-cycles/${cycleId}/criteria-form`);
      const form = formRes.data;
      setCriteriaForm(form);

      const criteriaRes = await axiosInstance.get(`/criteria-forms/${form.criteria_form_id}/criterias`);
      const criteriaList = criteriaRes.data;
      setCriterias(criteriaList);

      const allQuestions = [];
      for (const criteria of criteriaList) {
        const questionsRes = await axiosInstance.get(`/evaluation-criterias/${criteria.evaluation_criteria_id}/questions`);
        const questionsWithCriteria = questionsRes.data.map(q => ({
          ...q,
          criteria_name: criteria.criteria_name
        }));
        allQuestions.push(...questionsWithCriteria);
      }

      setQuestions(allQuestions);
    } catch (err) {
      console.error('Lỗi khi lấy form/tiêu chí/câu hỏi:', err);
      setCriterias([]);
      setQuestions([]);
    }
  };

  const handleCycleChange = (e) => {
    const cycleId = e.target.value;
    setSelectedCycle(cycleId);
    if (cycleId) {
      fetchFormAndQuestions(cycleId);
    } else {
      setCriteriaForm(null);
      setCriterias([]);
      setQuestions([]);
    }
  };

  const handleScoreChange = (questionId, value) => {
    setScores({
      ...scores,
      [questionId]: value
    });
  };

  const handleSubmit = async () => {
    try {
      const payload = {
        evaluation_cycle_id: selectedCycle,
        employee_code: profile.code,
        answers: questions.map(q => ({
          question_id: q.question_id,
          employee_score: scores[q.question_id] || 0
        }))
      };

      await axiosInstance.post('/evaluation-answer-details', payload);
      alert('Lưu đánh giá thành công!');
    } catch (error) {
      console.error('Lỗi khi lưu đánh giá:', error);
      alert('Có lỗi xảy ra khi lưu đánh giá!');
    }
  };

  return (
    <MainLayout>
      <div className="mb-3">
        <label>Chọn chu kỳ đánh giá:</label>
        <select
          className="form-control"
          value={selectedCycle}
          onChange={handleCycleChange}
        >
          <option value="">-- Chọn chu kỳ --</option>
          {evaluationCycles.map((cycle) => (
            <option key={cycle.evaluation_cycle_id} value={cycle.evaluation_cycle_id}>
              {cycle.cycle_name}
            </option>
          ))}
        </select>
      </div>

      <table className="table table-bordered">
        <thead className="thead-dark">
          <tr>
            <th>Nội dung</th>
            <th>Điểm tối đa</th>
            <th>Nhân viên</th>
            <th>Quản lý</th>
            <th>Thống đốc</th>
            <th>Giám đốc</th>
          </tr>
        </thead>
        <tbody>
          {criterias.map((criteria) => {
            const relatedQuestions = questions.filter(
              (q) => q.evaluation_criteria_id === criteria.evaluation_criteria_id
            );

            return (
              <React.Fragment key={criteria.evaluation_criteria_id}>
                <tr className="table-secondary">
                  <td colSpan="6">
                    <strong>Tiêu chí: {criteria.criteria_name}</strong>
                  </td>
                </tr>
                {relatedQuestions.map((q) => (
                  <tr key={q.question_id}>
                    <td>{q.question_name}</td>
                    <td>{q.max_score}</td>
                    <td>
                      <input
                        type="number"
                        className="form-control"
                        min="0"
                        max={q.max_score}
                        value={scores[q.question_id] || ''}
                        onChange={(e) => handleScoreChange(q.question_id, e.target.value)}
                      />
                    </td>
                    <td><input className="form-control" disabled value="" /></td>
                    <td><input className="form-control" disabled value="" /></td>
                    <td><input className="form-control" disabled value="" /></td>
                  </tr>
                ))}
              </React.Fragment>
            );
          })}
        </tbody>
      </table>

      {questions.length > 0 && (
        <button className="btn btn-success" onClick={handleSubmit}>
          Lưu đánh giá
        </button>
      )}
    </MainLayout>
  );
}

export default EmployeeSelfEvaluation;
