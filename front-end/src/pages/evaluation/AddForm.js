import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate } from 'react-router-dom';
import MainLayout from '../MainLayout';

function AddForm() {
    const [formData, setFormData] = useState({
        criteria_form_name: '',
        evaluation_cycle_id: '',
        evaluation_criteria_ids: [],
    });

    const [cycles, setCycles] = useState([]);
    const [criterias, setCriterias] = useState([]);
    const [success, setSuccess] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    useEffect(() => {
        fetchCycles();
        fetchCriterias();
    }, []);

    const fetchCycles = async () => {
        const res = await axiosInstance.get('/evaluation-cycles');
        setCycles(res.data);
    };

    const fetchCriterias = async () => {
        const res = await axiosInstance.get('/evaluation-criterias');
        const filteredCriterias = res.data.filter(c => c.criteria_form_id === null);
        setCriterias(filteredCriterias);
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
            // 1. Tạo form mới
            const createRes = await axiosInstance.post('/criteria-forms', {
                criteria_form_name: formData.criteria_form_name,
                evaluation_cycle_id: formData.evaluation_cycle_id,
            });

            const createdForm = createRes.data;

            // 2. Gửi PUT request cho từng tiêu chí đã chọn
            const promises = formData.evaluation_criteria_ids.map(id =>
                axiosInstance.put(`/evaluation-criterias/${id}/add-criteria`, {
                    criteria_form_id: createdForm.criteria_form_id
                })
            );

            await Promise.all(promises);

            // 3. Thành công
            setSuccess('Tạo form và gán tiêu chí thành công!');
            setTimeout(() => navigate('/form-management'), 1500);
        } catch (err) {
            console.error(err);
            setError('Có lỗi xảy ra khi tạo form hoặc thêm tiêu chí!');
        }
    };


    return (
        <MainLayout>
            <div className="container mt-4">
                <h3>Thêm Form Đánh Giá</h3>
                {success && <div className="alert alert-success">{success}</div>}
                {error && <div className="alert alert-danger">{error}</div>}

                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label className="form-label">Tên Form</label>
                        <input type="text" className="form-control" name="criteria_form_name" required value={formData.criteria_form_name} onChange={handleInputChange} />
                    </div>

                    <div className="mb-3">
                        <label className="form-label">Chu kỳ đánh giá</label>
                        <select className="form-select" name="evaluation_cycle_id" required value={formData.evaluation_cycle_id} onChange={handleInputChange}>
                            <option value="">-- Chọn chu kỳ --</option>
                            {cycles.map(c => (
                                <option key={c.evaluation_cycle_id} value={c.evaluation_cycle_id}>{c.cycle_name}</option>
                            ))}
                        </select>
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

                    <button type="submit" className="btn btn-primary">Lưu</button>
                </form>
            </div>
        </MainLayout>
    );
}

export default AddForm;
