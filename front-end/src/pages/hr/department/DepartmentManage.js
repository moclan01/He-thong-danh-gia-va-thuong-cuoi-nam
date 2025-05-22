import axiosInstance from "../../../services/axiosInstance";
import MainLayout from "../../MainLayout";
import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

function DepartmentManager() {
    const [departments, setDepartments] = useState([]);
    const [formData, setFormData] = useState({
        department_name: '',
        vp_group: '',
        manage_code: '',
    });
    const [editingId, setEditingId] = useState(null);
    const navigate = useNavigate();

    useEffect(() => {
        fetchDepartments();
    }, []);

    const fetchDepartments = async () => {
        try {
            const res = await axiosInstance.get('/departments');
            setDepartments(res.data);
        } catch (error) {
            console.error('Lỗi khi tải danh sách phòng ban:', error);
        }
    };

    const handleDelete = async (id) => {
        if (window.confirm('Bạn có chắc chắn muốn xóa phòng ban này không?')) {
            try {
                await axiosInstance.delete(`/departments/${id}`);
                fetchDepartments();
            } catch (error) {
                console.error('Lỗi khi xóa phòng ban:', error);
            }
        }
    };
    return (
        <MainLayout>
            <div className="container mt-4">
                <h2>Quản lý Phòng ban</h2>
                <button className="btn btn-primary mb-3" onClick={() => navigate('/department/add')}>
                    Thêm phòng ban
                </button>
                <table className="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên phòng ban</th>
                            <th>Nhóm VP</th>
                            <th>Trưởng phòng (code)</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        {departments.map((dept) => (
                            <tr key={dept.department_id}>
                                <td>{dept.department_id}</td>
                                <td>{dept.department_name}</td>
                                <td>{dept.vp_group}</td>
                                <td>{dept.manage_code || '-'}</td>
                                <td>
                                    <button
                                        className="btn btn-sm btn-warning me-2"
                                        onClick={() => navigate(`/department/update/${dept.department_id}`)}
                                    >
                                        Sửa
                                    </button>
                                    <button
                                        className="btn btn-sm btn-danger"
                                        onClick={() => handleDelete(dept.department_id)}
                                    >
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        ))}
                        {departments.length === 0 && (
                            <tr>
                                <td colSpan="5" className="text-center">
                                    Không có dữ liệu
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </MainLayout>
    );
}

export default DepartmentManager;