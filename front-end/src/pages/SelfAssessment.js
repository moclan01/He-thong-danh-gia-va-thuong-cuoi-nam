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
      // setScores(prevScores => {
      //   const newScores = { ...prevScores };
      //   questions.forEach(q => {
      //     if (newScores[q.evaluation_question_id] === undefined) {
      //       newScores[q.evaluation_question_id] = 0;
      //     }
      //   });
      //   return newScores;
      // });
      setScores(prev => {
        const updated = { ...prev };
        questions.forEach(q => {
          if (updated[q.evaluation_question_id] === undefined) {
            updated[q.evaluation_question_id] = 0;
          }
        });
        return updated;
      });

      setComments(prev => {
        const updated = { ...prev };
        questions.forEach(q => {
          if (!updated[q.evaluation_question_id]) {
            updated[q.evaluation_question_id] = '';
          }
        });
        return updated;
      });
    }
  }, [questions]);

  // useEffect(() => {
  //   const questionIds = questions.map(q => q.evaluation_question_id);
  //   const uniqueIds = new Set(questionIds);
  //   if (questionIds.length !== uniqueIds.size) {
  //     console.error('Duplicate evaluation_question_id found:', questionIds);
  //   }
  // }, [questions]);

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

  const handleScoreChange = (questionId, value) => {
    const num = parseInt(value, 10);
    setScores(prev => ({
      ...prev,
      [questionId]: isNaN(num) || num < 0 ? 0 : num
    }));
  };

  const handleCommentChange = (questionId, value) => {
    setComments(prev => ({
      ...prev,
      [questionId]: value
    }));
  };

  const handleSubmit = async () => {
    try {
      if (role !== 'employee') {
        alert('Bạn không có quyền thực hiện hành động này.');
        return;
      }

      for (const q of questions) {
        const score = scores[q.evaluation_question_id] || 0;
        const comment = comments[q.evaluation_question_id]?.employee_comment || '';

        if (score > 100 && score < 121 && comment.trim() === '') {
          alert(
            `Điểm trên 100 cần nhập lý do`
          );
          return;
        }
      }

      const totalScore = questions.reduce((sum, q) => {
        return sum + Number(scores[q.evaluation_question_id] || 0);
      }, 0);

      // Gửi đánh giá tổng trước
      const answerRes = await axiosInstance.post('/evaluation-answers', {
        code: profile.code,
        criteria_form_id: criteriaForm.criteria_form_id,
        total_score: totalScore
      });


      const evaluationAnswerId = answerRes.data.evaluation_answer_id;

      // Chuẩn bị chi tiết điểm
      const batchScoreData = questions.map((q) => ({
        evaluation_question_id: q.evaluation_question_id,
        evaluation_answer_id: evaluationAnswerId,
        employee_score: parseInt(scores[q.evaluation_question_id] || 0, 10),
      }));



      // Gửi batch điểm chi tiết
      const detailRes = await axiosInstance.post('/evaluation-answer-details/employee/batch', {
        data: batchScoreData
      });

      // Tạo batch comment
      const batchCommentData = detailRes.data.map((item) => ({
        evaluation_answer_detail_id: item.evaluation_answer_detail_id,
        employee_comment: comments[item.evaluation_question_id]?.employee_comment || ''
      }));

      // Gửi batch comment
      await axiosInstance.put('/evaluation-answer-details/employee/comments/batch', {
        data: batchCommentData
      });

      console.log('Kết quả lưu chi tiết:', detailRes.data);
      alert('Lưu đánh giá thành công!');
    } catch (error) {
      if (error.response && error.response.status === 422) {
        console.error('Lỗi xác thực (validation):', error.response.data.errors);
        alert('Dữ liệu không hợp lệ: ' + JSON.stringify(error.response.data.errors));
      } else {
        console.error('Lỗi khi lưu đánh giá:', error);
        alert('Có lỗi xảy ra khi lưu đánh giá!');
      }
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
            <th style={{ width: '30%' }}>Nội dung</th>
            <th style={{ width: '5%' }}>Điểm tối đa</th>
            <th style={{ width: '10%' }}>Nhân viên</th>
            <th style={{ width: '40%' }}>Nhận xét</th>
            <th style={{ width: '5%' }}>Giám sát</th>
            <th style={{ width: '5%' }}>Nhận xét</th>
            <th style={{ width: '5%' }}>Quản lý</th>
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
                    <td style={{ width: '200px' }}>{q.question_name}</td>
                    <td>{q.max_score}</td>
                    <td>
                      <input
                        type="number"
                        className="form-control"
                        min="0"
                        max={q.max_score}
                        value={scores[q.evaluation_question_id] || 0}
                        onChange={(e) =>
                          handleScoreChange(q.evaluation_question_id, e.target.value)
                        }
                        disabled={role !== 'employee'}
                      />
                    </td>
                    <td>
                      <input
                        type="text"
                        className="form-control"
                        value={comments[q.evaluation_question_id]?.employee_comment || ''}
                        onChange={(e) =>
                          handleCommentChange(q.evaluation_question_id, 'employee_comment', e.target.value)
                        }
                        disabled={role !== 'employee'}
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
