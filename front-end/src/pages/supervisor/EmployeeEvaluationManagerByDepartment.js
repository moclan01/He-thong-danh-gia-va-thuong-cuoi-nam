import React, { useEffect, useState } from 'react';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from '../MainLayout';
import { useNavigate } from 'react-router-dom';

function EmployeesEvaluationManagementByDepartment() {
    const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;

    const [profile, setProfile] = useState({});
    const [departments, setDepartments] = useState([]);
    const [managedEmployees, setManagedEmployees] = useState([]);
    const [selectedDepartment, setSelectedDepartment] = useState(null);
    const navigate = useNavigate();

    useEffect(() => {
        initData()
    }, []);

    const initData = async () => {
        try {
            const userProfile = await fetchProfile();
            fetchDepartments();
        } catch (error) {
            console.error('Lỗi khi khởi tạo dữ liệu:', error);
        }
    };

    const fetchProfile = async () => {
        const res = await axiosInstance.get('/employee/profile');
        const userProfile = res.data;
        setProfile(userProfile);
        return userProfile;
    };


    const fetchDepartments = async () => {
        try {
            const res = await axiosInstance.get('/departments');
            setDepartments(res.data);
            console.log(res.data)
        } catch (error) {
            console.error('Lỗi khi lấy danh sách phòng ban:', error);
        }
    };

    const fetchEmployeesByDepartment = async (departmentId) => {
        try {
            const res = await axiosInstance.get(`/employees/department/${departmentId}/employees-only`);
            setManagedEmployees(res.data);
            console.log(res.data)
        } catch (error) {
            console.error('Lỗi khi lấy danh sách nhân viên theo phòng ban:', error);
        }
    };

    const handleDepartmentChange = (e) => {
        const departmentId = e.target.value;
        setSelectedDepartment(departmentId);
        fetchEmployeesByDepartment(departmentId);
        console.log(departmentId);
    };

    return (
        <MainLayout>
            <div className="container mt-4">
                <h2>Quản lý đánh giá nhân viên theo phòng ban</h2>

                <div className="form-group mt-3">
                    <label>Chọn phòng ban:</label>
                    <select
                        className="form-control w-50"
                        value={selectedDepartment || ''}
                        onChange={handleDepartmentChange}
                    >
                        <option value="">-- Chọn phòng ban --</option>
                        {departments.map((dept) => (
                            <option key={dept.department_id} value={dept.department_id}>
                                {dept.department_name}
                            </option>
                        ))}
                    </select>
                </div>

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
                        {managedEmployees.length > 0 ? (
                            managedEmployees.map((emp) => (
                                <tr key={emp.employee_id}>
                                    <td>{emp.code}</td>
                                    <td>{emp.fullname}</td>
                                    <td>{emp.position?.name || '---'}</td>
                                    <td>
                                        <button className="btn btn-success" onClick={() => navigate(`/evaluate/supervisor/${emp.code}`)}>
                                            Đánh giá
                                        </button>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="4" className="text-center">
                                    Không có nhân viên nào trong phòng ban này.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </MainLayout>
    )
}

export default EmployeesEvaluationManagementByDepartment;