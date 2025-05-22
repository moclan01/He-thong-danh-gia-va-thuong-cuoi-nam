import axiosInstance from "../../../services/axiosInstance";
import MainLayout from "../../MainLayout";
import React, { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

function UpdateDepartment() {
    const { id } = useParams();
    const [formData, setFormData] = useState({
        department_name: '',
        vp_group: '',
        manage_code: '',
    });
    const navigate = useNavigate();

    useEffect(() => {
        fetchDepartment();
    }, []);

    const fetchDepartment = async () => {
        try {
            const res = await axiosInstance.get(`/departments/${id}`);
            setFormData(res.data);
        } catch (error) {
            console.error('Lỗi khi tải thông tin phòng ban:', error);
        }
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axiosInstance.put(`/departments/${id}`, formData);
            alert('Cập nhật phòng ban thành công');
            navigate('/departments');
        } catch (error) {
            console.error('Lỗi khi cập nhật phòng ban:', error);
            alert('Cập nhật phòng ban thất bại');
        }
    };

    return (
        <MainLayout>
            <div className="container mt-4">
                <h2>Cập nhật Phòng Ban</h2>
                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label>Tên phòng ban</label>
                        <input
                            type="text"
                            className="form-control"
                            name="department_name"
                            value={formData.department_name}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div className="mb-3">
                        <label>Nhóm VP</label>
                        <input
                            type="text"
                            className="form-control"
                            name="vp_group"
                            value={formData.vp_group}
                            onChange={handleChange}
                        />
                    </div>
                    <div className="mb-3">
                        <label>Trưởng phòng (mã nhân viên)</label>
                        <input
                            type="text"
                            className="form-control"
                            name="manage_code"
                            value={formData.manage_code}
                            onChange={handleChange}
                        />
                    </div>
                    <button type="submit" className="btn btn-primary me-2">
                        Cập nhật
                    </button>
                    <button type="button" className="btn btn-secondary" onClick={() => navigate('/departments')}>
                        Hủy
                    </button>
                </form>
            </div>
        </MainLayout>
    );
}

export default UpdateDepartment;