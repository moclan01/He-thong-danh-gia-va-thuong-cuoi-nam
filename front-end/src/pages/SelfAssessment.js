import React, { useEffect, useState } from 'react';
import MainLayout from './MainLayout';
import axiosInstance from '../services/axiosInstance';

function EmployeeSelfEvaluation() {
  const user = JSON.parse(localStorage.getItem('user'));
  const role = user?.role;

  const [profile, setProfile] = useState({});
  const [evaluationCycles, setEvaluationCycles] = useState([]);
  const [selectedCycle, setSelectedCycle] = useState('');
  const [criteriaForm, setCriteriaForm] = useState(null);
  const [criterias, setCriterias] = useState([]);
  const [questions, setQuestions] = useState([]);
  const [scores, setScores] = useState({});
  const [comments, setComments] = useState({});

  useEffect(() => {
    if (questions.length > 0) {
      setScores(prev => {
        const updated = { ...prev };
        questions.forEach(q => {
          if (!updated[q.evaluation_question_id]) {
            updated[q.evaluation_question_id] = {
              employee: 0,
              supervisor: 0,
              manager: 0
            };
          }
        });
        return updated;
      });

      setComments(prev => {
        const updated = { ...prev };
        questions.forEach(q => {
          if (!updated[q.evaluation_question_id]) {
            updated[q.evaluation_question_id] = {
              employee: '',
              supervisor: '',
              manager: ''
            };
          }
        });
        return updated;
      });
    }
  }, [questions]);

  useEffect(() => {
    fetchProfileAndCycles();
  }, []);

  const fetchProfileAndCycles = async () => {
    try {
      const res = await axiosInstance.get('/employee/profile');
      setProfile(res.data);

      const code = res.data.code;
      console.log(code)
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
        const questionsRes = await axiosInstance.get(
          `/evaluation-criterias/${criteria.evaluation_criteria_id}/questions`
        );

        const questionsWithCriteria = questionsRes.data.map((q) => ({
          evaluation_question_id: q.evaluation_question_id,
          evaluation_criteria_id: q.evaluation_criteria_id,
          question_name: q.question_name,
          max_score: q.max_score,
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
      setScores({});
      setComments({});
    }
  };

  const handleScoreChange = (questionId, field, value) => {
    const num = parseInt(value, 10);
    setScores(prev => ({
      ...prev,
      [questionId]: {
        ...prev[questionId],
        [field]: isNaN(num) || num < 0 ? 0 : num
      }
    }));
  };

  const handleCommentChange = (questionId, field, value) => {
    setComments(prev => ({
      ...prev,
      [questionId]: {
        ...prev[questionId],
        [field]: value
      }
    }));
  };

  const handleEmployeeSubmit = async () => {
    try {
      if (!profile.code || !criteriaForm?.criteria_form_id) {
        alert('Thiếu thông tin hồ sơ hoặc biểu mẫu đánh giá.');
        return;
      }

      for (const q of questions) {
        const score = scores[q.evaluation_question_id]?.employee || 0;
        const comment = comments[q.evaluation_question_id]?.employee || '';
        if (score > 100 && score <= 120 && comment.trim() === '') {
          alert(`Điểm trên 100 cho câu hỏi "${q.question_name}" cần có lý do.`);
          return;
        }
      }

      const totalScore = questions.reduce((sum, q) => {
        const score = scores[q.evaluation_question_id]?.employee || 0;
        return sum + Number(score);
      }, 0);

      const answerRes = await axiosInstance.post('/evaluation-answers', {
        code: profile.code,
        criteria_form_id: criteriaForm.criteria_form_id,
        total_score: totalScore
      });

      const evaluationAnswerId = answerRes.data.evaluation_answer_id;

      const batchScoreData = questions.map((q) => ({
        evaluation_question_id: q.evaluation_question_id,
        evaluation_answer_id: evaluationAnswerId,
        employee_score: parseInt(scores[q.evaluation_question_id]?.employee || 0, 10)
      }));

      const detailRes = await axiosInstance.post('/evaluation-answer-details/employee/batch', {
        data: batchScoreData
      });

      const batchCommentData = detailRes.data.map((item, index) => ({
        evaluation_answer_detail_id: item.evaluation_answer_detail_id,
        employee_comment: comments[questions[index].evaluation_question_id]?.employee || ''
      }));

      await axiosInstance.patch('/evaluation-answer-details/employee/batch', {
        data: batchCommentData
      });

      alert('Lưu đánh giá nhân viên thành công!');
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } catch (error) {
      if (error.response && error.response.status === 422) {
        console.error('Lỗi xác thực:', error.response.data.errors);
        alert('Dữ liệu không hợp lệ: ' + JSON.stringify(error.response.data.errors));
      } else {
        console.error('Lỗi khi lưu đánh giá:', error);
        alert('Có lỗi xảy ra khi lưu đánh giá!');
      }
    }
  };

  const handleSupervisorSubmit = async () => {
    try {
      if (!profile.code || !criteriaForm?.criteria_form_id) {
        alert('Thiếu thông tin hồ sơ hoặc biểu mẫu đánh giá.');
        return;
      }

      // Kiểm tra điểm hợp lệ (tùy chỉnh nếu cần)
      for (const q of questions) {
        const score = scores[q.evaluation_question_id]?.supervisor || 0;
        if (score > q.max_score) {
          alert(`Điểm cho câu hỏi "${q.question_name}" vượt quá điểm tối đa (${q.max_score}).`);
          return;
        }
      }

      const totalScore = questions.reduce((sum, q) => {
        const score = scores[q.evaluation_question_id]?.supervisor || 0;
        return sum + Number(score);
      }, 0);

      // Giả định endpoint tương tự, cần xác nhận với backend
      const answerRes = await axiosInstance.post('/evaluation-answers', {
        code: profile.code,
        criteria_form_id: criteriaForm.criteria_form_id,
        total_score: totalScore
      });

      const evaluationAnswerId = answerRes.data.evaluation_answer_id;

      const batchScoreData = questions.map((q) => ({
        evaluation_question_id: q.evaluation_question_id,
        evaluation_answer_id: evaluationAnswerId,
        supervisor_score: parseInt(scores[q.evaluation_question_id]?.supervisor || 0, 10),
        supervisor_comment: comments[q.evaluation_question_id]?.supervisor || ''
      }));

      const detailRes = await axiosInstance.post('/evaluation-answer-details/supervisor/batch', {
        data: batchScoreData
      });

      const batchCommentData = detailRes.data.map((item, index) => ({
        evaluation_answer_detail_id: item.evaluation_answer_detail_id,
        supervisor_comment: comments[questions[index].evaluation_question_id]?.supervisor || ''
      }));

      await axiosInstance.patch('/evaluation-answer-details/supervisor/batch', {
        data: batchCommentData
      });

      alert('Lưu đánh giá giám sát thành công!');
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } catch (error) {
      if (error.response && error.response.status === 422) {
        console.error('Lỗi xác thực:', error.response.data.errors);
        alert('Dữ liệu không hợp lệ: ' + JSON.stringify(error.response.data.errors));
      } else {
        console.error('Lỗi khi lưu đánh giá:', error);
        alert('Có lỗi xảy ra khi lưu đánh giá!');
      }
    }
  };

  const handleManagerSubmit = async () => {
    try {
      if (!profile.code || !criteriaForm?.criteria_form_id) {
        alert('Thiếu thông tin hồ sơ hoặc biểu mẫu đánh giá.');
        return;
      }

      // Kiểm tra điểm hợp lệ
      for (const q of questions) {
        const score = scores[q.evaluation_question_id]?.manager || 0;
        if (score > q.max_score) {
          alert(`Điểm cho câu hỏi "${q.question_name}" vượt quá điểm tối đa (${q.max_score}).`);
          return;
        }
      }

      const totalScore = questions.reduce((sum, q) => {
        const score = scores[q.evaluation_question_id]?.manager || 0;
        return sum + Number(score);
      }, 0);

      // Giả định endpoint tương tự, cần xác nhận với backend
      const answerRes = await axiosInstance.post('/evaluation-answers', {
        code: profile.code,
        criteria_form_id: criteriaForm.criteria_form_id,
        total_score: totalScore
      });

      const evaluationAnswerId = answerRes.data.evaluation_answer_id;

      const batchScoreData = questions.map((q) => ({
        evaluation_question_id: q.evaluation_question_id,
        evaluation_answer_id: evaluationAnswerId,
        manager_score: parseInt(scores[q.evaluation_question_id]?.manager || 0, 10)
      }));

      await axiosInstance.post('/evaluation-answer-details/manager/batch', {
        data: batchScoreData
      });

      alert('Lưu đánh giá quản lý thành công!');
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } catch (error) {
      if (error.response && error.response.status === 422) {
        console.error('Lỗi xác thực:', error.response.data.errors);
        alert('Dữ liệu không hợp lệ: ' + JSON.stringify(error.response.data.errors));
      } else {
        console.error('Lỗi khi lưu đánh giá:', error);
        alert('Có lỗi xảy ra khi lưu đánh giá!');
      }
    }
  };

  const handleSubmit = () => {
    if (role === 'employee') {
      handleEmployeeSubmit();
    } else if (role === 'supervisor') {
      handleSupervisorSubmit();
    } else if (role === 'manager') {
      handleManagerSubmit();
    } else {
      alert('Vai trò không hợp lệ.');
    }
  };

  const columnWidths = {
    employee: {
      content: '30%',
      maxScore: '5%',
      employee: '15%',
      employeeComment: '40%',
      supervisor: '5%',
      supervisorComment: '5%',
      manager: '5%',
    },
    supervisor: {
      content: '30%',
      maxScore: '5%',
      employee: '5%',
      employeeComment: '5%',
      supervisor: '15%',
      supervisorComment: '40%',
      manager: '5%',
    },
    manager: {
      content: '30%',
      maxScore: '5%',
      employee: '10%',
      employeeComment: '15%',
      supervisor: '10%',
      supervisorComment: '15%',
      manager: '15%',
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
            <th style={{ width: columnWidths[role]?.content || '30%' }}>Nội dung</th>
            <th style={{ width: columnWidths[role]?.maxScore || '5%' }}>Điểm tối đa</th>
            <th style={{ width: columnWidths[role]?.employee || '10%' }}>Nhân viên</th>
            <th style={{ width: columnWidths[role]?.employeeComment || '40%' }}>Nhận xét</th>
            <th style={{ width: columnWidths[role]?.supervisor || '5%' }}>Giám sát</th>
            <th style={{ width: columnWidths[role]?.supervisorComment || '5%' }}>Nhận xét</th>
            <th style={{ width: columnWidths[role]?.manager || '5%' }}>Quản lý</th>
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
                  <td colSpan="7">
                    <strong>Tiêu chí: {criteria.criteria_name}</strong>
                  </td>
                </tr>
                {relatedQuestions.map((q) => (
                  <tr key={q.evaluation_question_id}>
                    <td>{q.question_name}</td>
                    <td>{q.max_score}</td>

                    {/* Nhân viên chấm điểm */}
                    <td>
                      <input
                        type="number"
                        className="form-control"
                        min="0"
                        max={q.max_score}
                        value={scores[q.evaluation_question_id]?.employee || 0}
                        onChange={(e) =>
                          handleScoreChange(q.evaluation_question_id, 'employee', e.target.value)
                        }
                        disabled={role !== 'employee'}
                      />
                    </td>
                    <td>
                      <input
                        type="text"
                        className="form-control"
                        value={comments[q.evaluation_question_id]?.employee || ''}
                        onChange={(e) =>
                          handleCommentChange(q.evaluation_question_id, 'employee', e.target.value)
                        }
                        disabled={role !== 'employee'}
                      />
                    </td>

                    {/* Giám sát chấm điểm */}
                    <td>
                      <input
                        type="number"
                        className="form-control"
                        min="0"
                        max={q.max_score}
                        value={scores[q.evaluation_question_id]?.supervisor || 0}
                        onChange={(e) =>
                          handleScoreChange(q.evaluation_question_id, 'supervisor', e.target.value)
                        }
                        disabled={role !== 'supervisor'}
                      />
                    </td>
                    <td>
                      <input
                        type="text"
                        className="form-control"
                        value={comments[q.evaluation_question_id]?.supervisor || ''}
                        onChange={(e) =>
                          handleCommentChange(q.evaluation_question_id, 'supervisor', e.target.value)
                        }
                        disabled={role !== 'supervisor'}
                      />
                    </td>

                    {/* Quản lý chấm điểm */}
                    <td>
                      <input
                        type="number"
                        className="form-control"
                        min="0"
                        max={q.max_score}
                        value={scores[q.evaluation_question_id]?.manager || 0}
                        onChange={(e) =>
                          handleScoreChange(q.evaluation_question_id, 'manager', e.target.value)
                        }
                        disabled={role !== 'manager'}
                      />
                    </td>
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
