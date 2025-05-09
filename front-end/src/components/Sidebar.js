import React from 'react';
import { useNavigate } from 'react-router-dom';

export default function Sidebar() {
    const navigate = useNavigate();
    const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;

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
                <li className="nav-item mb-2">
                    <button className="btn btn-link text-white nav-link" onClick={() => navigate('/self-assessment')}>
                        Tự đánh giá
                    </button>
                </li>
                <li className="nav-item mb-2">
                    <button className="btn btn-link text-white nav-link" onClick={() => navigate('/evaluation-results')}>
                        Xem kết quả đánh giá
                    </button>
                </li>
                <li className="nav-item mb-2">
                    <button className="btn btn-link text-white nav-link" onClick={() => navigate('/evaluation-history')}>
                        Lịch sử đánh giá
                    </button>
                </li>
                {(role === 'manager' || role === 'supervisor') && (
                    <>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/group-assessment')}>
                                Quản lý đánh giá tập thể
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/peer-assessment')}>
                                Đánh giá đồng cấp
                            </button>
                        </li>
                    </>
                )}
                {/* Supervisor-specific */}
                {role === 'supervisor' && (
                    <>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/evaluate-managers')}>
                                Đánh giá quản lý
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/cycle-management')}>
                                Quản lý chu kỳ đánh giá
                            </button>
                        </li>
                        <li className="nav-item mb-2">
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/form-setup')}>
                                Tạo form đánh giá
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
                            <button className="btn btn-link text-white nav-link" onClick={() => navigate('/criteria-management')}>
                                Quản lý tiêu chí đánh giá
                            </button>
                        </li>
                    </>
                )}
            </ul>
        </div>
    );
}
