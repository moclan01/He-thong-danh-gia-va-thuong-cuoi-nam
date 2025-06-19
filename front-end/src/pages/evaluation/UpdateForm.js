import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';

function UpdateForm() {
    const { id } = useParams(); // Lấy criteria_form_id từ URL
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        criteria_form_name: '',
        evaluation_cycle_id: '',
        evaluation_criteria_ids: [],
    });
    const [cycles, setCycles] = useState([]);
    const [criterias, setCriterias] = useState([]);
    const [success, setSuccess] = useState('');
    const [error, setError] = useState('');

    useEffect(() => {
        fetchForm();
        fetchCycles();
        fetchCriterias();
    }, [id]);

    const fetchForm = async () => {
        try {
            const res = await axiosInstance.get(`/criteria-forms/${id}`);
            const form = res.data;
            // Lấy danh sách tiêu chí đã gán
            const criteriaRes = await axiosInstance.get(`/criteria-forms/${id}/criterias`);
            setFormData({
                criteria_form_name: form.criteria_form_name,
                evaluation_cycle_id: form.evaluation_cycle_id,
                evaluation_criteria_ids: criteriaRes.data.map(c => c.evaluation_criteria_id),
            });
        } catch (err) {
            setError('Không thể tải thông tin form.');
            console.error(err);
        }
    };

    const fetchCycles = async () => {
        try {
            const res = await axiosInstance.get('/evaluation-cycles');
            setCycles(res.data);
        } catch (err) {
            setError('Không thể tải danh sách chu kỳ.');
            console.error(err);
        }
    };

    const fetchCriterias = async () => {
        try {
            // Lấy tiêu chí chưa gán và tiêu chí đã gán cho form hiện tại
            const [unassignedRes, assignedRes] = await Promise.all([
                axiosInstance.get('/evaluation-criterias'),
                axiosInstance.get(`/criteria-forms/${id}/criterias`),
            ]);
            const filteredCriterias = unassignedRes.data.filter(c => c.criteria_form_id === null);
            setCriterias([...filteredCriterias, ...assignedRes.data]);
        } catch (err) {
            setError('Không thể tải danh sách tiêu chí.');
            console.error(err);
        }
    };

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleCriteriaChange = (id) => {
        setFormData((prev) => {
            const ids = prev.evaluation_criteria_ids.includes(id)
                ? prev.evaluation_criteria_ids.filter(cid => cid !== id)
                : [...prev.evaluation_criteria_ids, id];
            return { ...prev, evaluation_criteria_ids: ids };
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        setSuccess('');

        try {
            // 1. Cập nhật thông tin form
            await axiosInstance.put(`/criteria-forms/${id}`, {
                criteria_form_name: formData.criteria_form_name,
                evaluation_cycle_id: formData.evaluation_cycle_id,
            });

            // 2. Lấy danh sách tiêu chí hiện tại của form
            const currentCriteriaRes = await axiosInstance.get(`/criteria-forms/${id}/criterias`);
            const currentCriteriaIds = currentCriteriaRes.data.map(c => c.evaluation_criteria_id);

            // 3. Xác định tiêu chí cần thêm hoặc xóa
            const criteriaToAdd = formData.evaluation_criteria_ids.filter(
                id => !currentCriteriaIds.includes(id)
            );
            const criteriaToRemove = currentCriteriaIds.filter(
                id => !formData.evaluation_criteria_ids.includes(id)
            );

            // 4. Gửi PUT request để gán hoặc bỏ gán tiêu chí
            for (const criteriaId of criteriaToAdd) {
                await axiosInstance.put(`/evaluation-criterias/${criteriaId}/add-criteria`, {
                    criteria_form_id: id, // ID của form từ useParams
                });
            }

            for (const criteriaId of criteriaToRemove) {
                await axiosInstance.put(`/evaluation-criterias/${criteriaId}/add-criteria`, {
                    criteria_form_id: null,
                });
            }

            // 5. Thành công
            setSuccess('Cập nhật form và tiêu chí thành công!');
            setTimeout(() => navigate('/form-management'), 1500);
        } catch (err) {
            console.error(err);
            setError('Có lỗi xảy ra khi cập nhật form hoặc tiêu chí!');
        }
    };

    return (
        <MainLayout>
            <div className="container mt-4">
                <h3>Cập nhật Form Đánh Giá</h3>
                {success && <div className="alert alert-success">{success}</div>}
                {error && <div className="alert alert-danger">{error}</div>}

                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label className="form-label">Tên Form</label>
                        <input
                            type="text"
                            className="form-control"
                            name="criteria_form_name"
                            required
                            value={formData.criteria_form_name}
                            onChange={handleInputChange}
                        />
                    </div>

                    <div className="mb-3">
                        <label className="form-label">Chu kỳ đánh giá</label>
                        <p className="form-control-static">
                            {cycles.find(c => c.evaluation_cycle_id === formData.evaluation_cycle_id)?.cycle_name || '--'}
                        </p>
                    </div>

                    <div className="mb-3">
                        <label className="form-label">Chọn tiêu chí đánh giá</label>
                        {criterias.map(c => (
                            <div className="form-check" key={c.evaluation_criteria_id}>
                                <input
                                    type="checkbox"
                                    className="form-check-input"
                                    checked={formData.evaluation_criteria_ids.includes(c.evaluation_criteria_id)}
                                    onChange={() => handleCriteriaChange(c.evaluation_criteria_id)}
                                />
                                <label className="form-check-label">{c.criteria_name}</label>
                            </div>
                        ))}
                    </div>

                    <div className="d-flex justify-content-end">
                        <button
                            type="button"
                            className="btn btn-secondary me-2"
                            onClick={() => navigate('/form-management')}
                        >
                            Hủy
                        </button>
                        <button type="submit" className="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </MainLayout>
    );
}

export default UpdateForm;