import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import MainLayout from '../MainLayout';
import axiosInstance from '../../services/axiosInstance';

function SupervisorEvaluateEmployee() {
    const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;
    const { code } = useParams();
    const [evaluationCycles, setEvaluationCycles] = useState([]);
    const [selectedCycle, setSelectedCycle] = useState('');
    const [criteriaForm, setCriteriaForm] = useState(null);
    const [criterias, setCriterias] = useState([]);
    const [questions, setQuestions] = useState([]);
    const [scores, setScores] = useState({});
    const [evaluationAnswerId, setEvaluationAnswerId] = useState(null);
    const [answerDetails, setAnswerDetails] = useState([]);
    const [employeeScores, setEmployeeScores] = useState({});
    const [managerScores, setManagerScores] = useState({});

    useEffect(() => {
        if (questions.length > 0) {
            setScores(prevScores => {
                const newScores = { ...prevScores };
                questions.forEach(q => {
                    if (newScores[q.evaluation_question_id] === undefined) {
                        newScores[q.evaluation_question_id] = 0;
                    }
                });
                return newScores;
            });
        }
    }, [questions]);

    useEffect(() => {
        const questionIds = questions.map(q => q.evaluation_question_id);
        const uniqueIds = new Set(questionIds);
        if (questionIds.length !== uniqueIds.size) {
            console.error('Duplicate evaluation_question_id found:', questionIds);
        }
    }, [questions]);

    useEffect(() => {
        fetchCycles();
    }, []);

    const fetchCycles = async () => {
        try {
            const cycleRes = await axiosInstance.get(`/employees/${code}/evaluation-cycles`);
            setEvaluationCycles(cycleRes.data);
        } catch (error) {
            console.error('Lỗi khi lấy hoặc chu kỳ:', error);
        }
    };

    const fetchFormAndQuestions = async (cycleId) => {
        try {
            const formRes = await axiosInstance.get(`/evaluation-cycles/${cycleId}/criteria-form`);
            const form = formRes.data;
            setCriteriaForm(form);

            await fetchScoreEmployeeAnswer(form.criteria_form_id);

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
            setScores({});
            setEmployeeScores({});
        }
    };

    const fetchScoreEmployeeAnswer = async (formId) => {
        try {
            // Lấy evaluation_answer theo code và formId
            const answerRes = await axiosInstance.get(`/evaluation-answers/by-code-and-form-id/${code}/${formId}`);
            const answer = answerRes.data;
            setEvaluationAnswerId(answer.evaluation_answer_id);
            console.log(`evaluation_answer_id: ${answer.evaluation_answer_id}`)

            // Lấy chi tiết điểm
            const detailsRes = await axiosInstance.get(`/evaluation-answers/${answer.evaluation_answer_id}/details`);
            const details = detailsRes.data.evaluation_answer_details;
            setAnswerDetails(details);
            console.log(details)

            // Map điểm employee_score, manager_score theo evaluation_question_id
            const newEmployeeScores = {};
            const newManagerScores = {};
            details.forEach(detail => {
                newEmployeeScores[detail.evaluation_question_id] = detail.employee_score;
                newManagerScores[detail.evaluation_question_id] = detail.manager_score;
            });
            setEmployeeScores(newEmployeeScores);
            setManagerScores(newManagerScores);
            console.log(newEmployeeScores)
            console.log('Manager scores:', newManagerScores);
        } catch (error) {
            console.error('Lỗi khi lấy EvaluationAnswer hoặc chi tiết:');

            if (error.response) {
                console.error('Status:', error.response.status);
                console.error('Data:', error.response.data);
                console.error('Headers:', error.response.headers);
            } else if (error.request) {
                console.error('Request error:', error.request);
            } else {
                console.error('Message:', error.message);
            }

            setEvaluationAnswerId(null);
            setAnswerDetails([]);
            setEmployeeScores({});
            setManagerScores({});
            setScores({});
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
            setEmployeeScores({});
        }
    };

    const handleScoreChange = (questionId, value, maxScore) => {
        let numValue = value === '' ? 0 : parseInt(value, 10);
        if (isNaN(numValue) || numValue < 0) numValue = 0;
        if (numValue > maxScore) numValue = maxScore;
        setScores(prevScores => {
            const newScores = {
                ...prevScores,
                [questionId]: numValue,
            };
            console.log('Updated scores:', newScores);
            return newScores;
        });
    };

    const handleSubmit = async () => {
        try {
            if (role !== 'supervisor') {
                alert('Bạn không có quyền thực hiện hành động này.');
                return;
            }

            const totalScore = questions.reduce((sum, q) => {
                return sum + Number(scores[q.evaluation_question_id] || 0);
            }, 0);

            // Gửi đánh giá tổng trước
            const answerRes = await axiosInstance.put(`/evaluation-answers/${evaluationAnswerId}/update-supervisor-score`, {
                evaluation_answer_id: evaluationAnswerId,
                total_score_supervisor: totalScore
            });

            const batchData = answerDetails.map((detail) => ({
                evaluation_answer_detail_id: detail.evaluation_answer_detail_id,
                supervisor_score: parseInt(scores[detail.evaluation_question_id] || 0, 10),
            }))

            const detailRes = await axiosInstance.put('/evaluation-answer-details/supervisor/batch', {
                data: batchData
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
            <div>
                <h1>Đánh giá nhân viên có mã: {code}</h1>
            </div>
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
                        <th style={{ width: '7.5%' }}>Nhân viên</th>
                        <th style={{ width: '20%' }}>Nhận xét</th>
                        <th style={{ width: '10%' }}>Giám sát</th>
                        <th style={{ width: '22.5%' }}>Nhận xét</th>
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
                                        <td>{q.question_name}</td>
                                        <td>{q.max_score}</td>
                                        <td>
                                            <input
                                                className="form-control"
                                                disabled
                                                value={employeeScores[q.evaluation_question_id] ?? 0}
                                            />
                                        </td>
                                        <td><input className="form-control" disabled value="" /></td>
                                        <td>
                                            <input
                                                type="number"
                                                className="form-control"
                                                min="0"
                                                max={q.max_score}
                                                value={scores[q.evaluation_question_id] ?? 0}
                                                onChange={(e) =>
                                                    handleScoreChange(q.evaluation_question_id, e.target.value, q.max_score)
                                                }
                                                disabled={role !== 'supervisor'}
                                            />
                                        </td>
                                        <td><input className="form-control" value="" /></td>
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

export default SupervisorEvaluateEmployee;