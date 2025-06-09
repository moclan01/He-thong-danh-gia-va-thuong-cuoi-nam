import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';
import { useNavigate } from 'react-router-dom';

function SupervisorsEvaluationManagement() {
const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;
    const navigate = useNavigate();

    const [profile, setProfile] = useState({});
    const [managedSupervisors, setManagedSupervisors] = useState([]);
    const [departmentName, setDepartmentName] = useState('');

     useEffect(() => {
        if (role !== 'manager') {
            alert('Bạn không có quyền truy cập trang này.');
            navigate('/home');
            return;
        }
        initData();
    }, [role, navigate]);

    const initData = async () => {
        try {
            const userProfile = await fetchProfile();
            if (userProfile.department_id) {
                await fetchDepartmentName(userProfile.department_id);
                await fetchSupervisorsByDepartment(userProfile.department_id);
            } else {
                console.error('Không tìm thấy department_id trong profile.');
                alert('Không thể xác định phòng ban của bạn.');
            }
        } catch (error) {
            console.error('Lỗi khi khởi tạo dữ liệu:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu.');
        }
    };

    const fetchProfile = async () => {
        try {
            const res = await axiosInstance.get('/employee/profile');
            const userProfile = res.data;
            setProfile(userProfile);
            return userProfile;
        } catch (error) {
            console.error('Lỗi khi lấy profile:', error);
            throw error;
        }
    };

     const fetchDepartmentName = async (departmentId) => {
        try {
            const res = await axiosInstance.get(`/departments/${departmentId}`);
            setDepartmentName(res.data.department_name || 'Không xác định');
            console.log('Department name:', res.data.department_name);
        } catch (error) {
            console.error('Lỗi khi lấy tên phòng ban:', error);
            setDepartmentName('Không xác định');
            alert('Không thể tải tên phòng ban.');
        }
    };

    const fetchSupervisorsByDepartment = async (departmentId) => {
        try {
            const res = await axiosInstance.get(`/employees/department/${departmentId}/supervisor`);
            setManagedSupervisors(res.data);
            console.log('Supervisors:', res.data);
        } catch (error) {
            console.error('Lỗi khi lấy danh sách giám sát:', error);
            alert('Không thể tải danh sách giám sát.');
        }
    };

     return (
        <MainLayout>
            <div className="container mt-4">
                <h2>Danh sách giám sát phòng ban: {departmentName || 'Đang tải...'}</h2>

                <table className="table table-bordered mt-4">
                    <thead className="thead-dark">
                        <tr>
                            <th>Mã NV</th>
                            <th>Họ tên</th>
                            <th>Chức vụ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        {managedSupervisors.length > 0 ? (
                            managedSupervisors.map((sup) => (
                                <tr key={sup.employee_id}>
                                    <td>{sup.code}</td>
                                    <td>{sup.fullname}</td>
                                    <td>{sup.position?.name || '---'}</td>
                                    <td>
                                        <button
                                            className="btn btn-success"
                                            onClick={() => navigate(`/evaluate/supervisor/${sup.code}`)}
                                        >
                                            Đánh giá
                                        </button>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="4" className="text-center">
                                    Không có giám sát nào trong phòng ban của bạn.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </MainLayout>
    );
}

export default SupervisorsEvaluationManagement