import React, { useEffect, useState } from 'react';
import MainLayout from './MainLayout';
import axiosInstance from '../services/axiosInstance';
import { useNavigate } from 'react-router-dom';

function EvaluationHistory() {
    const [profile, setProfile] = useState({});
    const [historyList, setHistoryList] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchAllData();
    }, []);

    const fetchAllData = async () => {
        try {
            const profileRes = await axiosInstance.get('/employee/profile');
            const profileData = profileRes.data;
            setProfile(profileData);

            const code = profileData.code;

            const answersRes = await axiosInstance.get(`/evaluation-answers/employee/${code}`);
            const evaluationAnswers = answersRes.data;

            const cyclesRes = await axiosInstance.get(`/employees/${code}/evaluation-cycles`);
            const evaluationCycles = cyclesRes.data;

            const formsRes = await axiosInstance.get('/criteria-forms');
            const criteriaForms = formsRes.data;

            const history = evaluationCycles.map(cycle => {
                const formsOfCycle = criteriaForms.filter(form => form.evaluation_cycle_id === cycle.evaluation_cycle_id);

                const answersInCycle = evaluationAnswers.filter(answer =>
                    formsOfCycle.some(form => form.criteria_form_id === answer.criteria_form_id)
                );

                let totalScore = 'Chưa có đánh giá';
                let totalScoreManage = 'Chưa có đánh giá';
                let totalScoreSupervisor = 'Chưa có đánh giá';

                if (answersInCycle.length > 0) {
                    totalScore = Math.max(...answersInCycle.map(a => a.total_score ?? 0));
                    totalScoreManage = Math.max(...answersInCycle.map(a => a.total_score_manage ?? 0));
                    totalScoreSupervisor = Math.max(...answersInCycle.map(a => a.total_score_supervisor ?? 0));
                }

                return {
                    cycle_name: cycle.cycle_name,
                    start_date: cycle.start_date,
                    end_date: cycle.end_date,
                    total_score: totalScore,
                    total_score_manage: totalScoreManage,
                    total_score_supervisor: totalScoreSupervisor,
                    cycle_id: cycle.evaluation_cycle_id,
                };
            });

            setHistoryList(history);
        } catch (error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
        }
    };

    return (
        <MainLayout>
            <div className="container mt-4">
                <h3 className="mb-4">Lịch sử đánh giá của nhân viên: {profile.name}</h3>

                <table className="table table-bordered table-striped">
                    <thead className="thead-dark">
                        <tr>
                            <th>Chu kỳ đánh giá</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Điểm tự đánh giá</th>
                            <th>Điểm quản lý đánh giá</th>
                            <th>Điểm thống đốc đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        {historyList.length === 0 ? (
                            <tr>
                                <td colSpan="6" className="text-center">
                                    Chưa có dữ liệu lịch sử đánh giá
                                </td>
                            </tr>
                        ) : (
                            historyList.map((item, idx) => (
                                <tr key={idx}>
                                    <td>{item.cycle_name}</td>
                                    <td>{item.start_date}</td>
                                    <td>{item.end_date}</td>
                                    <td>{item.total_score}</td>
                                    <td>{item.total_score_manage}</td>
                                    <td>{item.total_score_supervisor}</td>
                                    <td>
                                        <button className="btn btn-primary btn-sm" onClick={() => navigate(`/evaluation-detail/${profile.code}/${item.cycle_id}`)}>
                                            Xem chi tiết
                                        </button>
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>
        </MainLayout>
    );
}

export default EvaluationHistory;
