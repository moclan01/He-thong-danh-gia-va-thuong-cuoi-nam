import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';
import { useNavigate } from 'react-router-dom';


function EmployeesEvaluationManagement() {

    const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;

    const [profile, setProfile] = useState({});
    const [managedEmployees, setManagedEmployees] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchProfileAndManagedEmployees();
        
    }, []);

    const fetchProfileAndManagedEmployees = async () => {
        try {
            const res = await axiosInstance.get('/employee/profile');
            const userProfile = res.data;
            setProfile(userProfile);

            // Gọi API lấy danh sách nhân viên có code_r = code của quản lý
            const code = userProfile.code;
            const managedRes = await axiosInstance.get(`/employees/code-r/${code}`);
            setManagedEmployees(managedRes.data);
        } catch (error) {
            console.error('Lỗi khi lấy danh sách nhân viên quản lý:', error);
        }
    };

    return (
        <MainLayout>
            <h1>Danh sách nhân viên</h1>
            <table className="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Chức vụ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {managedEmployees.map((emp) => (
                        <tr key={emp.employee_id}>
                            <td>{emp.code}</td>
                            <td>{emp.fullname}</td>
                            <td>{emp.position?.name || '---'}</td>
                            <td>
                                <button className="btn btn-success" onClick={() => navigate(`/evaluate/manage/${emp.code}`)}>
                                    Đánh giá
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </MainLayout>
    )
}

export default EmployeesEvaluationManagement;