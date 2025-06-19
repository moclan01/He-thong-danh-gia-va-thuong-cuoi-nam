import React from 'react';
import { useNavigate } from 'react-router-dom';

export default function Sidebar() {
    const navigate = useNavigate();
    const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;

    if (!user || !role) {
        return (
            <div className="bg-dark text-white p-3" style={{ width: '250px', height: '100vh' }}>
                <div>Vui lòng đăng nhập để xem menu.</div>
            </div>
        );
    }

    return (
        <div className="bg-dark text-white p-3" style={{ width: '250px', height: '100vh' }}>
            <h4 className="mb-4">Home</h4>
            <ul className="nav flex-column">
                
                <li className="nav-item mb-2">
                    <button className="btn btn-link text-white nav-link" onClick={() => navigate('/home')}>
                        Home
                    </button>
                </li>
                <li className="nav-item mb-2">
                    <button className="btn btn-link text-white nav-link" onClick={() => navigate('/profile')}>
                        Xem thông tin
                    </button>
                </li>
                <li className="nav-item mb-2">
                    <button className="btn btn-link text-white nav-link" onClick={() => navigate('/change-password')}>
                        Đổi mật khẩu
                    </button>
                </li>

                
                {(role === 'employee' || role === 'supervisor' || role === 'manager') && (
                    <>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/self-assessment')}>
                                Tự đánh giá
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/evaluation-history')}>
                                Lịch sử và kết quả đánh giá
                            </button>
                        </li>
                    </>
                )}

                
                {(role === 'supervisor' || role === 'manager') && (
                    <li className="nav-item mb-2">
                        <button
                            className="btn btn-link text-white nav-link"
                            onClick={() => navigate(role === 'supervisor' ? '/group-assessment-supervisor' : '/group-assessment-manager')}
                        >
                            Quản lý đánh giá tập thể
                        </button>
                    </li>
                )}

                
                {role === 'manager' && (
                    <>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/evaluate-supervisors')}>
                                Đánh giá giám sát
                            </button>
                        </li>
                
                    </>
                )}


                {role === 'hr' && (
                    <>

                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/employee-management')}>
                                Quản lý thông tin nhân viên
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/department-management')}>
                                Quản lý phòng ban
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/plant-management')}>
                                Quản lý plant
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/account-management')}>
                                Quản lý account
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/cycle-management')}>
                                Quản lý chu kỳ đánh giá
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/form-management')}>
                                Quản lý form đánh giá
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/criteria-management')}>
                                Quản lý tiêu chí đánh giá
                            </button>
                        </li>
                    </>
                )}

                
                {role === 'director' && (
                    <li className="nav-item mb-2">
                        <button className="btn btn-link text-white nav-link" onClick={() => navigate('/what-form-management')}>
                            Quản lý what_form
                        </button>
                    </li>
                )}
            </ul>
        </div>
    );
}
