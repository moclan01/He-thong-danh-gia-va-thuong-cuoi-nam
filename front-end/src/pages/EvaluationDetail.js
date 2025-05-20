
import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import MainLayout from './MainLayout';
import axiosInstance from '../services/axiosInstance';

function EvaluationAnswerDetail() {
    const { code, cycleId } = useParams();
    const [criteriaForm, setCriteriaForm] = useState(null);
    const [criterias, setCriterias] = useState([]);
    const [questions, setQuestions] = useState([]);
    const [scores, setScores] = useState({});
    const [evaluationAnswerId, setEvaluationAnswerId] = useState(null);
    const [answerDetails, setAnswerDetails] = useState([]);
    const [employeeScores, setEmployeeScores] = useState({});
    const [managerScores, setManagerScores] = useState({});
    const [supervisorScores, setSupervisorScores] = useState({});

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
  if (cycleId) {
    fetchFormAndQuestions(cycleId);
  }
}, [cycleId]);

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
            const newSupervisorScores = {};
            details.forEach(detail => {
                newEmployeeScores[detail.evaluation_question_id] = detail.employee_score;
                newManagerScores[detail.evaluation_question_id] = detail.manager_score;
                newSupervisorScores[detail.evaluation_question_id] = detail.supervisor_score;
            });
            setEmployeeScores(newEmployeeScores);
            setManagerScores(newManagerScores);
            setSupervisorScores(newSupervisorScores)
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
            setSupervisorScores({});
            setScores({});
        }
    };

    return (
        <MainLayout>
            <table className="table table-bordered">
                            <thead className="thead-dark">
                                <tr>
                                    <th>Nội dung</th>
                                    <th>Điểm tối đa</th>
                                    <th>Nhân viên</th>
                                    <th>Quản lý</th>
                                    <th>Thống đốc</th>
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
                                                    <td>
                                                        <input
                                                            className="form-control"
                                                            disabled
                                                            value={managerScores[q.evaluation_question_id] ?? 0}
                                                        />
                                                    </td>
                                                    <td>
                                                        <input
                                                            className="form-control"
                                                            disabled
                                                            value={supervisorScores[q.evaluation_question_id] ?? 0}
                                                        />
                                                    </td>
                                                </tr>
                                            ))}
                                        </React.Fragment>
                                    );
                                })}
                            </tbody>
                        </table>
        </MainLayout>
    );
}

export default EvaluationAnswerDetail;