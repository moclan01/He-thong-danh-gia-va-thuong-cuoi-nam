import React, { useState, useEffect } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate } from 'react-router-dom';
import MainLayout from '../MainLayout';
import FormInput from '../../components/FormInput';

function AddCycle() {
    const [formData, setFormData] = useState({
        cycle_name: '',
        start_date: '',
        end_date: '',
    });
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');
    const [departments, setDepartments] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchDepartments();
    }, []);

    const fetchDepartments = async () => {
        try {
            const res = await axiosInstance.get('/departments');
            setDepartments(res.data);
        } catch (err) {
            console.error('Không thể tải danh sách phòng ban');
        }
    };

    const handleChange = e => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async e => {
        e.preventDefault();
        try {
            await axiosInstance.post('/evaluation-cycles', formData);
            setSuccess('Thêm chu kỳ thành công.');
            setError('');
            setTimeout(() => navigate('/cycle-management'), 2000);
        } catch (err) {
            setError(err.response?.data?.message || 'Không thể thêm chu kỳ.');
        }
    };

    return (
        <MainLayout>
            <h2>Thêm chu kỳ đánh giá</h2>
            {error && <div className="alert alert-danger">{error}</div>}
            {success && <div className="alert alert-success">{success}</div>}
            <form onSubmit={handleSubmit}>
                <FormInput
                    label="Tên chu kỳ"
                    name="cycle_name"
                    value={formData.cycle_name}
                    onChange={handleChange}
                    required
                />
                <div className="mb-3">
                    <label htmlFor="department_id" className="form-label">Phòng ban</label>
                    <select
                        className="form-select"
                        name="department_id"
                        value={formData.department_id}
                        onChange={handleChange}
                        required
                    >
                        <option value="">-- Chọn phòng ban --</option>
                        {departments.map(dept => (
                            <option key={dept.department_id} value={dept.department_id}>
                                {dept.department_name}
                            </option>
                        ))}
                    </select>
                </div>
                <FormInput
                    label="Ngày bắt đầu"
                    name="start_date"
                    type="date"
                    value={formData.start_date}
                    onChange={handleChange}
                    required
                />
                <FormInput
                    label="Ngày kết thúc"
                    name="end_date"
                    type="date"
                    value={formData.end_date}
                    onChange={handleChange}
                    required
                />
                <div className="mb-3">
                    <label htmlFor="status" className="form-label">Trạng thái</label>
                    <select
                        className="form-select"
                        name="status"
                        value={formData.status}
                        onChange={handleChange}
                        required
                    >
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="open">Mở</option>
                        <option value="pending">Chờ xử lý</option>
                        <option value="closed">Đã đóng</option>
                    </select>
                </div>
                <div className="d-flex justify-content-end">
                    <button className="btn btn-secondary me-2" type="button" onClick={() => navigate('/cycle-management')}>
                        Hủy
                    </button>
                    <button className="btn btn-primary" type="submit">Thêm</button>
                </div>
            </form>
        </MainLayout>
    );
}

export default AddCycle;
