import React, { useEffect, useState } from 'react';
import MainLayout from './MainLayout';
import axiosInstance from '../services/axiosInstance';

function EvaluationHistory() {
    const user = JSON.parse(localStorage.getItem('user'));
    const [profile, setProfile] = useState({});
    const [evaluationCycles, setEvaluationCycles] = useState([]);
    const [criteriaForms, setCriteriaForms] = useState([]);
    const [evaluationAnswers, setEvaluationAnswers] = useState([]);
    const [historyList, setHistoryList] = useState([]);

    useEffect(() => {
        fetchAllData();
    }, []);

    const fetchAllData = async () => {
        try {
            // 1. Lấy profile
            const profileRes = await axiosInstance.get('/employee/profile');
            const profileData = profileRes.data;
            setProfile(profileData);

            const code = profileData.code;

            const answersRes = await axiosInstance.get(`/evaluation-answers/employee/${code}`);
            setEvaluationAnswers(answersRes.data);

            // 2. Lấy danh sách chu kỳ đánh giá của nhân viên
            const cyclesRes = await axiosInstance.get(`/employees/${code}/evaluation-cycles`);
            setEvaluationCycles(cyclesRes.data);

            // 3. Lấy tất cả form đánh giá
            const formsRes = await axiosInstance.get('/criteria-forms');
            setCriteriaForms(formsRes.data);

            // 5. Xử lý ghép dữ liệu lịch sử đánh giá
            const history = [];

            // Với mỗi chu kỳ, tìm form liên quan, sau đó tìm câu trả lời tương ứng
            evaluationCycles.forEach(cycle => {
                // Tìm tất cả các answer có form thuộc chu kỳ hiện tại
                // Lọc answers sao cho form của answer có evaluation_cycle_id = cycle.evaluation_cycle_id

                // Lấy các form của chu kỳ này
                const formsOfCycle = criteriaForms.filter(form => form.evaluation_cycle_id === cycle.evaluation_cycle_id);

                // Tìm các answer có criteria_form_id thuộc formsOfCycle
                const answersInCycle = evaluationAnswers.filter(answer =>
                    formsOfCycle.some(form => form.criteria_form_id === answer.criteria_form_id)
                );

                // Tổng điểm = tổng hoặc trung bình tổng_score của tất cả answers trong chu kỳ
                // (Tuỳ logic bạn muốn, mình sẽ lấy tổng điểm lớn nhất làm điểm đại diện)
                let totalScore = 'Chưa có đánh giá';
                if (answersInCycle.length > 0) {
                    // Lấy điểm max
                    totalScore = Math.max(...answersInCycle.map(a => a.total_score));
                }

                history.push({
                    cycle_name: cycle.cycle_name,
                    start_date: cycle.start_date,
                    end_date: cycle.end_date,
                    total_score: totalScore,
                });
            });

            setHistoryList(history);
        } catch (error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
        }
    };

    return (
        <MainLayout>
            <h3>Lịch sử đánh giá của nhân viên: {profile.name}</h3>
            <table className="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Chu kỳ đánh giá</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Tổng điểm</th>
                    </tr>
                </thead>
                <tbody>
                    {historyList.length === 0 && (
                        <tr>
                            <td colSpan="4" className="text-center">Chưa có dữ liệu lịch sử đánh giá</td>
                        </tr>
                    )}
                    {historyList.map((item, idx) => (
                        <tr key={idx}>
                            <td>{item.cycle_name}</td>
                            <td>{item.start_date}</td>
                            <td>{item.end_date}</td>
                            <td>{item.total_score}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </MainLayout>
    );
}

export default EvaluationHistory;
